<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* /home/ruslan/Projects/next/output/xcart/src/skins/admin/modules/XC/Stripe/welcome_block/vendor_stripe/block.content.twig */
class __TwigTemplate_d74f41d9c44ab3a2900933f87c20c165e9e67edb2f2db212d0a7772832d9aeb1 extends \XLite\Core\Templating\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 6
        echo "<div class=\"content\">
    <div class=\"stripe-logo\"></div>
    <div class=\"info\">
        <h2>";
        // line 9
        echo call_user_func_array($this->env->getFunction('t')->getCallable(), ["To accept online payments, you need a Stripe account"]);
        echo "</h2>
        <div>";
        // line 10
        echo call_user_func_array($this->env->getFunction('t')->getCallable(), ["You can connect existing Stripe account or create a new one on the [Financial Info page].", ["financialTabURL" => $this->getAttribute(($context["this"] ?? null), "getFinancialTabURL", [], "method")]]);
        echo "</div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "/home/ruslan/Projects/next/output/xcart/src/skins/admin/modules/XC/Stripe/welcome_block/vendor_stripe/block.content.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 10,  35 => 9,  30 => 6,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "/home/ruslan/Projects/next/output/xcart/src/skins/admin/modules/XC/Stripe/welcome_block/vendor_stripe/block.content.twig", "");
    }
}
