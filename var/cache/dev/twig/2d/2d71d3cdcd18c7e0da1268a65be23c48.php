<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* shared/components/_button.html.twig */
class __TwigTemplate_fd0e0462f40169af95c6fb627e4af6c2 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "shared/components/_button.html.twig"));

        // line 14
        yield "
";
        // line 15
        $context["button_content"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            // line 16
            yield "    ";
            if ((((array_key_exists("icon", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["icon"]) || array_key_exists("icon", $context) ? $context["icon"] : (function () { throw new RuntimeError('Variable "icon" does not exist.', 16, $this->source); })()), false)) : (false)) && ((isset($context["icon_position"]) || array_key_exists("icon_position", $context) ? $context["icon_position"] : (function () { throw new RuntimeError('Variable "icon_position" does not exist.', 16, $this->source); })()) == "left"))) {
                // line 17
                yield "        <span class=\"icon\">
            <i class=\"fas fa-";
                // line 18
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["icon"]) || array_key_exists("icon", $context) ? $context["icon"] : (function () { throw new RuntimeError('Variable "icon" does not exist.', 18, $this->source); })()), "html", null, true);
                yield "\"></i>
        </span>
    ";
            }
            // line 21
            yield "    
    <span>";
            // line 22
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("text", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["text"]) || array_key_exists("text", $context) ? $context["text"] : (function () { throw new RuntimeError('Variable "text" does not exist.', 22, $this->source); })()), "Click Me")) : ("Click Me")), "html", null, true);
            yield "</span>
    
    ";
            // line 24
            if ((((array_key_exists("icon", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["icon"]) || array_key_exists("icon", $context) ? $context["icon"] : (function () { throw new RuntimeError('Variable "icon" does not exist.', 24, $this->source); })()), false)) : (false)) && ((isset($context["icon_position"]) || array_key_exists("icon_position", $context) ? $context["icon_position"] : (function () { throw new RuntimeError('Variable "icon_position" does not exist.', 24, $this->source); })()) == "right"))) {
                // line 25
                yield "        <span class=\"icon\">
            <i class=\"fas fa-";
                // line 26
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["icon"]) || array_key_exists("icon", $context) ? $context["icon"] : (function () { throw new RuntimeError('Variable "icon" does not exist.', 26, $this->source); })()), "html", null, true);
                yield "\"></i>
        </span>
    ";
            }
            // line 29
            yield "    
    ";
            // line 30
            if (array_key_exists("content", $context)) {
                // line 31
                yield "        ";
                yield (isset($context["content"]) || array_key_exists("content", $context) ? $context["content"] : (function () { throw new RuntimeError('Variable "content" does not exist.', 31, $this->source); })());
                yield "
    ";
            }
            yield from [];
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 34
        yield "
<button 
    type=\"";
        // line 36
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("type", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 36, $this->source); })()), "button")) : ("button")), "html", null, true);
        yield "\"
    class=\"button ";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("classes", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["classes"]) || array_key_exists("classes", $context) ? $context["classes"] : (function () { throw new RuntimeError('Variable "classes" does not exist.', 37, $this->source); })()), "is-primary")) : ("is-primary")), "html", null, true);
        yield " ";
        yield (((($tmp = ((array_key_exists("icon", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["icon"]) || array_key_exists("icon", $context) ? $context["icon"] : (function () { throw new RuntimeError('Variable "icon" does not exist.', 37, $this->source); })()), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("has-icon") : (""));
        yield "\"
    ";
        // line 38
        if ((($tmp = ((array_key_exists("disabled", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["disabled"]) || array_key_exists("disabled", $context) ? $context["disabled"] : (function () { throw new RuntimeError('Variable "disabled" does not exist.', 38, $this->source); })()), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "disabled";
        }
        // line 39
        yield "    ";
        if (array_key_exists("attributes", $context)) {
            // line 40
            yield "        ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["attributes"]) || array_key_exists("attributes", $context) ? $context["attributes"] : (function () { throw new RuntimeError('Variable "attributes" does not exist.', 40, $this->source); })()));
            foreach ($context['_seq'] as $context["attr"] => $context["value"]) {
                // line 41
                yield "            ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["attr"], "html", null, true);
                yield "=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
                yield "\"
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['attr'], $context['value'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 43
            yield "    ";
        }
        // line 44
        yield ">
    ";
        // line 45
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["button_content"]) || array_key_exists("button_content", $context) ? $context["button_content"] : (function () { throw new RuntimeError('Variable "button_content" does not exist.', 45, $this->source); })()), "html", null, true);
        yield "
</button>

";
        // line 49
        yield "<style>
    /* Gradient buttons */
    .button.gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        border-radius: 50px;
        padding: 15px 30px;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    
    .button.gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    
    .button.gradient-sunset {
        background: linear-gradient(to right, #f7971e, #ffd200);
        border: none;
        color: #333;
        border-radius: 50px;
        border: 3px solid #ffd200;
    }
    
    /* Glass button */
    .button.glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 12px;
    }
    
    /* Icon spacing */
    .button.has-icon .icon {
        margin: 0 8px;
    }
</style>";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "shared/components/_button.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  143 => 49,  137 => 45,  134 => 44,  131 => 43,  120 => 41,  115 => 40,  112 => 39,  108 => 38,  102 => 37,  98 => 36,  94 => 34,  86 => 31,  84 => 30,  81 => 29,  75 => 26,  72 => 25,  70 => 24,  65 => 22,  62 => 21,  56 => 18,  53 => 17,  50 => 16,  48 => 15,  45 => 14,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{# 
    Button Component
    ================
    Parameters:
    - text: Button text (or use 'content' for HTML)
    - content: HTML content for the button (overrides 'text')
    - type: button type (default: 'button')
    - classes: CSS classes (space separated)
    - icon: Font Awesome icon name (e.g., 'rocket')
    - icon_position: 'left' or 'right' (default: 'left')
    - attributes: Additional HTML attributes as array
    - disabled: Boolean
#}

{% set button_content %}
    {% if icon|default(false) and icon_position == 'left' %}
        <span class=\"icon\">
            <i class=\"fas fa-{{ icon }}\"></i>
        </span>
    {% endif %}
    
    <span>{{ text|default('Click Me') }}</span>
    
    {% if icon|default(false) and icon_position == 'right' %}
        <span class=\"icon\">
            <i class=\"fas fa-{{ icon }}\"></i>
        </span>
    {% endif %}
    
    {% if content is defined %}
        {{ content|raw }}
    {% endif %}
{% endset %}

<button 
    type=\"{{ type|default('button') }}\"
    class=\"button {{ classes|default('is-primary') }} {{ icon|default(false) ? 'has-icon' : '' }}\"
    {% if disabled|default(false) %}disabled{% endif %}
    {% if attributes is defined %}
        {% for attr, value in attributes %}
            {{ attr }}=\"{{ value }}\"
        {% endfor %}
    {% endif %}
>
    {{ button_content }}
</button>

{# Custom Styles for this component #}
<style>
    /* Gradient buttons */
    .button.gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        border-radius: 50px;
        padding: 15px 30px;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    
    .button.gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    
    .button.gradient-sunset {
        background: linear-gradient(to right, #f7971e, #ffd200);
        border: none;
        color: #333;
        border-radius: 50px;
        border: 3px solid #ffd200;
    }
    
    /* Glass button */
    .button.glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 12px;
    }
    
    /* Icon spacing */
    .button.has-icon .icon {
        margin: 0 8px;
    }
</style>", "shared/components/_button.html.twig", "/home/mjperez/SymProj/omph-hiv-001/templates/shared/components/_button.html.twig");
    }
}
