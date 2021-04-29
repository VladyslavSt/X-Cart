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

/* /home/ruslan/Projects/next/output/xcart/src/skins/admin/modules/XPay/XPaymentsCloud/order/transactions/list.twig */
class __TwigTemplate_0a26db897e0bc4e1362c5088b6a21c6052693c665f47b0676f4c402efc3ff192 extends \XLite\Core\Templating\Twig\Template
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
        echo "
";
        // line 7
        if ($this->getAttribute($this->getAttribute(($context["this"] ?? null), "order", []), "getXpaymentsCards", [], "method")) {
            // line 8
            echo "  <div class=\"xpayments-transactions line-3\">

  <table class=\"xpayments-cards\">
    ";
            // line 11
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute(($context["this"] ?? null), "order", []), "getXpaymentsCards", [], "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["card"]) {
                // line 12
                echo "      <tr>

        <td class=\"card-column\">
          ";
                // line 15
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('widget')->getCallable(), [$this->env, $context, [0 => "\\XLite\\Module\\XPay\\XPaymentsCloud\\View\\Card", "card" => $context["card"]]]), "html", null, true);
                echo "
        </td>

        <td class=\"links-column\">
          <a class=\"dotted\" href=\"javascript: void(0);\" onclick=\"javascript: popupXpaymentsInfo('";
                // line 19
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute($context["card"], "xpid", []), "html", null, true);
                echo "');\">";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), ["View payment information"]), "html", null, true);
                echo "</a>
          <a href=\"";
                // line 20
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, $this->getAttribute($context["card"], "url", []), "html", null, true);
                echo "\" target=\"blank\">";
                echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), ["Go to payment details page"]), "html", null, true);
                echo "</a>
        </td>

      </tr>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['card'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 25
            echo "  </table>
  </div>
";
        }
        // line 28
        echo "
<br/>
";
    }

    public function getTemplateName()
    {
        return "/home/ruslan/Projects/next/output/xcart/src/skins/admin/modules/XPay/XPaymentsCloud/order/transactions/list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 28,  75 => 25,  62 => 20,  56 => 19,  49 => 15,  44 => 12,  40 => 11,  35 => 8,  33 => 7,  30 => 6,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "/home/ruslan/Projects/next/output/xcart/src/skins/admin/modules/XPay/XPaymentsCloud/order/transactions/list.twig", "");
    }
}
