<?php
namespace App\MoneyKeeper\Helpers;

/**
 *  Form helper
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class Form {

	/**
	 * Generates dropdown select	 
	 * 
	 * @param  [type] $name    input name
	 * @param  array $arOptions options
	 * @param  string $value   value	 
	 * @param  string  $class   additional class
	 *
	 * @return string html code of dropdown
	 */
	public static function dropdownSelect ($name, $arOptions, $value, $class = '') {
	    $input = '<input type="hidden" name="'.htmlspecialchars($name).'" value="'.htmlspecialchars($value).'" />';
			$title = trans('mkeep.not_selected');
			$id = 'dwopdown-'.htmlspecialchars($name).'-'.time();
			
			if (isset($arOptions[$value])) {
				$title = $arOptions[$value];
			}
						
			$btn = '<a class="btn dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">'.htmlspecialchars($title).' <span class="caret"></span></a>';
			$options = '<ul class="dropdown-menu dropdown-select scrollable-menu" role="menu">';
			foreach($arOptions as $v=>$t) {
				$options .= '<li class="dropdown-item'.($v==$value?' active':'').'" data-id="'.htmlspecialchars($v).'"><span>'.$t.'</span></li>';
			}
			$options .= '</ul>';
			
			$js = '
			<script type="text/javascript">
			$(document).ready(function(){
				$("#'.$id.' li").click(function(){
				  var selText = $(this).html();
				  $(this).parents(".dropdown").find(".dropdown-toggle").html(selText+" <span class=\"caret\"></span>");
					$(this).parents(".dropdown").find("input[type=hidden]").val($(this).attr("data-id"));
					$("#'.$id.' li").removeClass("active");
					$(this).addClass("active");
				});
				
				var val = $("#'.$id.' li").eq(0).attr("data-id");
				console.log(val);
				if ($("#'.$id.' li.active").length>0) {
					val = $("#'.$id.' li.active").eq(0).attr("data-id");
				}
				console.log(val);
				var selText =$("#'.$id.' li[data-id="+val+"]").html();
				$("#'.$id.'").find(".dropdown-toggle").html(selText+" <span class=\"caret\"></span>");
				$("#'.$id.'").find("input[type=hidden]").val(val);
				$("#'.$id.' li").removeClass("active");
				$("#'.$id.' li[data-id="+val+"]").addClass("active");
			});
			</script>
			';
			
			return '<div class="dropdown '.htmlspecialchars($class).'" id="'.$id.'">'.$input.$btn.$options.'</div>'.$js;
			
	}

}
