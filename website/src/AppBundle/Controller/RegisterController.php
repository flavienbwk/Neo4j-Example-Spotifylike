<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use GraphAware\Neo4j\Client\ClientBuilder;

class RegisterController extends Controller {

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder) {
        $flashbag = $this->get('session')->getFlashBag();
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $headers = [
                'Accept' => 'application/json',
                'x-api-key' => 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3'
            ];
            $parameters = array('username' => $user->getUsername(), 'password' => $user->getPassword(), 'email' => $user->getEmail());

            $client = ClientBuilder::create()
                    ->addConnection('default', 'http://neo4j:r6F7DPsr@localhost:7474')
                    ->addConnection('bolt', 'bolt://neo4j:r6F7DPsr@localhost:7687')
                    ->build();

            $result = $client->run('MATCH (a:Artist) RETURN a LIMIT 1');
            $query = $result->getRecords();
            if (!empty($query)) {

                $query = $client->run("MERGE (u:User {username: {username}, email: {email}, password:{password}}) \n RETURN u,ID(u)", $parameters);

                $query_check = $client->run("MATCH (u:User {username: {username}, email: {email}}) \n RETURN u,ID(u)", $parameters);
                if (sizeof($query_check->getRecords()) != 0) {

                    $em->persist($user);
                    $em->flush();

                    $flashbag->add(
                            'flash_successes', "You have successfuly registered. Please connect."
                    );
                } else {
                    $flashbag->add(
                            'flash_errors', "Impossible to register the user in the graph database."
                    );
                }
            } else {
                $flashbag->add(
                        'flash_errors', "An error occured while connecting to the database."
                );
            }

            return $this->redirectToRoute("login");
        }

        return $this->render('@App/Register/register.html.twig', array(
                    "form" => $form->createView()
        ));
    }

}
