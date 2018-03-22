<?php

/* navbar.html.twig */
class __TwigTemplate_261b6b8dcf4d5cf68cfddf285c59254f0d14afe06f74cdabe0d3db110ad2c9c0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "navbar.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "navbar.html.twig"));

        // line 1
        echo "<nav class=\"navbar navbar-inverse bg-inverse navbar-toggleable-md\">
    <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarsExampleCenteredNav\" aria-controls=\"navbarsExampleCenteredNav\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
        <span class=\"navbar-toggler-icon\"></span>
    </button>

    <div class=\"collapse navbar-collapse justify-content-md-center\" id=\"navbarsExampleCenteredNav\">
        <ul class=\"navbar-nav\">

            ";
        // line 9
        if ($this->env->getExtension('Symfony\Bridge\Twig\Extension\SecurityExtension')->isGranted("IS_AUTHENTICATED_FULLY")) {
            // line 10
            echo "                <li class=\"nav-item\">
                    <a href=\"";
            // line 11
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\LogoutUrlExtension')->getLogoutPath(), "html", null, true);
            echo "\" class=\"btn btn-secondary\">Logout</a>
                </li>
            ";
        } else {
            // line 14
            echo "                <li class=\"nav-item\">
                    <a href=\"";
            // line 15
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("login");
            echo "\" class=\"btn btn-success\">Login</a>
                </li>
                <li class=\"nav-item px-2\">
                    <a href=\"";
            // line 18
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("register");
            echo "\" class=\"btn btn-warning\">Register</a>
                </li>
            ";
        }
        // line 21
        echo "        </ul>
    </div>
</nav>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "navbar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  61 => 21,  55 => 18,  49 => 15,  46 => 14,  40 => 11,  37 => 10,  35 => 9,  25 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<nav class=\"navbar navbar-inverse bg-inverse navbar-toggleable-md\">
    <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarsExampleCenteredNav\" aria-controls=\"navbarsExampleCenteredNav\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
        <span class=\"navbar-toggler-icon\"></span>
    </button>

    <div class=\"collapse navbar-collapse justify-content-md-center\" id=\"navbarsExampleCenteredNav\">
        <ul class=\"navbar-nav\">

            {% if is_granted('IS_AUTHENTICATED_FULLY') %}
                <li class=\"nav-item\">
                    <a href=\"{{ logout_path() }}\" class=\"btn btn-secondary\">Logout</a>
                </li>
            {% else %}
                <li class=\"nav-item\">
                    <a href=\"{{ path('login') }}\" class=\"btn btn-success\">Login</a>
                </li>
                <li class=\"nav-item px-2\">
                    <a href=\"{{ path('register') }}\" class=\"btn btn-warning\">Register</a>
                </li>
            {% endif %}
        </ul>
    </div>
</nav>", "navbar.html.twig", "/var/www/datacamp/app/Resources/views/navbar.html.twig");
    }
}
