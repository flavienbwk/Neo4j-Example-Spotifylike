<?php

/* @App/Default/notifications.html.twig */
class __TwigTemplate_df5f85961d1d3ea75169dde203ba48d6daa2d99555c12adbf8cd5c405036d4b7 extends Twig_Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@App/Default/notifications.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@App/Default/notifications.html.twig"));

        // line 1
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["app"] ?? $this->getContext($context, "app")), "flashes", array(0 => "flash_errors"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flash_error"]) {
            // line 2
            echo "    <div class=\"alert alert-danger flash-notice\">
        ";
            // line 3
            echo twig_escape_filter($this->env, $context["flash_error"], "html", null, true);
            echo "
    </div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flash_error'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 6
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["app"] ?? $this->getContext($context, "app")), "flashes", array(0 => "flash_infos"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flash_info"]) {
            // line 7
            echo "    <div class=\"alert alert-info flash-notice\">
        ";
            // line 8
            echo twig_escape_filter($this->env, $context["flash_info"], "html", null, true);
            echo "
    </div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flash_info'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 11
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["app"] ?? $this->getContext($context, "app")), "flashes", array(0 => "flash_successes"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flash_success"]) {
            // line 12
            echo "    <div class=\"alert alert-info flash-notice\">
        ";
            // line 13
            echo twig_escape_filter($this->env, $context["flash_success"], "html", null, true);
            echo "
    </div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flash_success'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@App/Default/notifications.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  64 => 13,  61 => 12,  57 => 11,  48 => 8,  45 => 7,  41 => 6,  32 => 3,  29 => 2,  25 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% for flash_error in app.flashes('flash_errors') %}
    <div class=\"alert alert-danger flash-notice\">
        {{ flash_error }}
    </div>
{% endfor %}
{% for flash_info in app.flashes('flash_infos') %}
    <div class=\"alert alert-info flash-notice\">
        {{ flash_info }}
    </div>
{% endfor %}
{% for flash_success in app.flashes('flash_successes') %}
    <div class=\"alert alert-info flash-notice\">
        {{ flash_success }}
    </div>
{% endfor %}", "@App/Default/notifications.html.twig", "/var/www/datacamp/src/AppBundle/Resources/views/Default/notifications.html.twig");
    }
}
