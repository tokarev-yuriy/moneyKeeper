@php 
  $date = '';
@endphp
@if(empty($arTransactions) || count($arTransactions)==0)
	<div class="card" style="border-radius: 0;">
	<div class="card-header"><h3>{{ trans('mkeep.no_data') }}</h3></div>
	</div>
@endif
@foreach($arTransactions as $i=>$arItem)
	<div class="card mb-0" style="border-radius: 0;">
		<div class="card-body bg-{{ $arItem['type'] }} p-2">
			<input type="hidden" name="importTransaction[{{ $i }}][value]" value="{{ $arItem['value'] }}" />
			<input type="hidden" name="importTransaction[{{ $i }}][type]" value="{{ $arItem['type'] }}" />
			<input type="hidden" name="importTransaction[{{ $i }}][ext_id]" value="{{ $arItem['ext_id'] }}" />
			<input type="hidden" name="importTransaction[{{ $i }}][comment]" value="{{ $arItem['comment'] }}" />
			<div class="col-12">
				<div class="card-btns pl-2">
					<a class="btn btn-dark" data-btn-type="delete" href="javascript: void(0);" onclick="$(this).parents('.card').remove();"><i class="fa fa-remove fa-lg"></i></a>
				</div>
				<div class="row">
					<div class="col-8">
						<div style="width: 140px;">
						{!! Form::input('date', 'importTransaction['. $i .'][date]', $arItem['date'], array('class'=>'form-control')) !!}
						</div>
						<div class="
						  @if($arItem['type']=='spend')
						  bg-danger
						  @elseif($arItem['type']=='income')
						  bg-success
						  @elseif($arItem['type']=='transfer')
						  bg-secondary
						  @endif 
						  category-icon">
							@if(isset($arDictionaries['category_icon'][$arItem['category_id']]))
							<img src="{{ $arDictionaries['category_icon'][$arItem['category_id']] }}" alt="{{ $arDictionaries['category_id'][$arItem['category_id']] }}">
							@endif
						</div>
						<span>
						@php
							echo \App\MoneyKeeper\Helpers\Form::dropdownSelect('importTransaction['.$i.'][category_id]', \App\MoneyKeeper\Models\Operation::getTypeCategoriesWithIcons($arItem['type']), $arItem['category_id']);
						@endphp
						</span>

						{{ $arItem['wallet'] }}
					</div>
					<div class="col-4  text-right">
						<span class="h3 
						  @if($arItem['type']=='spend')
							text-danger
						  @elseif($arItem['type']=='income')
							text-success
						  @elseif($arItem['type']=='transfer')
							text-secondary
						  @endif
						  "
						>
							@if($arItem['type']=='spend')
							  -
							@elseif($arItem['type']=='income')
							  +
							@endif
							{{ Number::curf($arItem['value']) }}
						</span>
						<div class="text-secondary card-comment">{{ $arItem['comment'] }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endforeach