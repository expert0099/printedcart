<!--<div id="loading" style="text-align:center;"></div>-->
<table class="item-pricing">
	<tbody>
		<tr class="">
			<td class="item-description">20 pages included</td>
			<td class=""></td>
			<td class="">{!! $data['default_currency']['currencysymbol'] !!}{!! number_format($data['size'][0]['price'],2) !!}</td>
			<input type="hidden" name="photobook_price" id="photobook_price" value="{!! number_format($data['size'][0]['price'],2) !!}"/>
		</tr>
		<tr class="">
			<td class="item-description">Cover Page</td>
			<td class=""></td>
			<td class="">{!! $data['default_currency']['currencysymbol'] !!}{!! number_format($data['photobook_cover_price']['price'],2) !!}</td>
			<input type="hidden" name="photobook_cover_price" id="photobook_cover_price" value="{!! number_format($data['photobook_cover_price']['price'],2) !!}"/>
		</tr>
		<tr class="">
			<td class="item-description">Each additional page</td>
			<td class=""></td>
			<td class="">{!! $data['default_currency']['currencysymbol'] !!}{!! number_format($data['size'][0]['price']/20,2) !!}</td>
			<input type="hidden" name="extra_page_price" id="extra_page_price" value="{!! number_format($data['size'][0]['price']/20,2) !!}"/>
		</tr>
	</tbody>
</table>