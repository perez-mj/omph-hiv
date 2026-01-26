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

/* shared/components/_modal.html.twig */
class __TwigTemplate_fdccf58a69a10eb9ab60a9160748426b extends Template
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
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "shared/components/_modal.html.twig"));

        // line 2
        yield "
<div x-data=\"{ isOpen: false }\">
    <button class=\"button ";
        // line 4
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("btnClass", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["btnClass"]) || array_key_exists("btnClass", $context) ? $context["btnClass"] : (function () { throw new RuntimeError('Variable "btnClass" does not exist.', 4, $this->source); })()), "is-primary")) : ("is-primary")), "html", null, true);
        yield "\" @click=\"isOpen = true\">
        ";
        // line 5
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("btnLabel", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["btnLabel"]) || array_key_exists("btnLabel", $context) ? $context["btnLabel"] : (function () { throw new RuntimeError('Variable "btnLabel" does not exist.', 5, $this->source); })()), "Open Modal")) : ("Open Modal")), "html", null, true);
        yield "
    </button>

    <div class=\"modal\" :class=\"{ 'is-active': isOpen }\">
        <div class=\"modal-background\" @click=\"isOpen = false\"></div>
        <div class=\"modal-card\">
            <header class=\"modal-card-head\">
                <p class=\"modal-card-title\">";
        // line 12
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new RuntimeError('Variable "title" does not exist.', 12, $this->source); })()), "html", null, true);
        yield "</p>
                <button class=\"delete\" aria-label=\"close\" @click=\"isOpen = false\"></button>
            </header>
            <section class=\"modal-card-body\">
                ";
        // line 16
        yield (isset($context["content"]) || array_key_exists("content", $context) ? $context["content"] : (function () { throw new RuntimeError('Variable "content" does not exist.', 16, $this->source); })());
        yield "
            </section>
        </div>
    </div>
</div>";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "shared/components/_modal.html.twig";
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
        return array (  70 => 16,  63 => 12,  53 => 5,  49 => 4,  45 => 2,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{# templates/shared/components/_modal.html.twig #}

<div x-data=\"{ isOpen: false }\">
    <button class=\"button {{ btnClass|default('is-primary') }}\" @click=\"isOpen = true\">
        {{ btnLabel|default('Open Modal') }}
    </button>

    <div class=\"modal\" :class=\"{ 'is-active': isOpen }\">
        <div class=\"modal-background\" @click=\"isOpen = false\"></div>
        <div class=\"modal-card\">
            <header class=\"modal-card-head\">
                <p class=\"modal-card-title\">{{ title }}</p>
                <button class=\"delete\" aria-label=\"close\" @click=\"isOpen = false\"></button>
            </header>
            <section class=\"modal-card-body\">
                {{ content|raw }}
            </section>
        </div>
    </div>
</div>", "shared/components/_modal.html.twig", "/home/mjperez/SymProj/omph-hiv-001/templates/shared/components/_modal.html.twig");
    }
}
