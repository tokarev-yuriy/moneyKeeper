   {!! Form::open(array('url' => ((isset($obItem) && $obItem->id)?$paths['update'].'/'.$obItem->id:$paths['add']))) !!}

        <div class="row form-group">
            <label for="name" class="col-md-4 control-label">{{ trans('mkeep.name') }}</label>
            <div class="col-md-6">
                {!! Form::text('name', Input::get('name', isset($obItem)?$obItem->name:''), array('class'=>(isset($errors) && $errors->has('name') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('name'))
                        <strong>{{ $errors->first('name') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
         <div class="row form-group">
            <label for="category_id" class="col-md-4 control-label">{{ trans('mkeep.wallet_group') }}</label>
            <div class="col-md-6">
                {!!Form::select('group_id', \App\MoneyKeeper\Models\Wallet::getWalletGroups(), Input::get('group_id', isset($obItem)?$obItem->group_id:''), array('class'=>(isset($errors) && $errors->has('group_id') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('group_id'))
                        <strong>{{ $errors->first('group_id') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="icon" class="col-md-4 control-label">{{ trans('mkeep.icon') }}</label>
            <div class="col-md-6">
                @php 
                  $itemId = ((isset($obItem) && $obItem->id)?$obItem->id:0);
                @endphp
				
				<div class="form-group">
					<div class="btn-group">
						<button type="button" class="btn btn-secondary iconpicker-component">
							<i class="fa fa-fw fa-{{ Input::get('icon', isset($obItem)?$obItem->icon:'') }}"></i>
						</button>
						<button type="button" id="icp-wallet-{{$itemId}}" class="btn btn-secondary dropdown-toggle" data-selected="fa-car" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<div class="dropdown-menu"></div>
					</div>
				</div>
				
                <div id="iconselect-wallet-icon-{{ $itemId }}"></div>
                {!! Form::hidden('icon', Input::get('icon', isset($obItem)?$obItem->icon:''), array('id'=>'wallet-icon-'.$itemId)) !!}
                <script>
                @php
                    $jsIcons = [];
                    foreach(\App\MoneyKeeper\Models\Wallet::getWalletIcons() as $code=>$title) {
                        $jsIcons[] = ['title'=>$title, 'searchTerms'=>$code];
                    }
                @endphp
				$('#icp-wallet-{{$itemId}}').iconpicker({
					icons: <?=json_encode($jsIcons)?>
				});
				$('#icp-wallet-{{$itemId}}').on('iconpickerSelected', function(event){
				  /* event.iconpickerValue */
				  $('#wallet-icon-{{$itemId}}').val(event.iconpickerValue.replace('fas fa-',''));
				});
                </script>

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('icon'))
                        <strong>{{ $errors->first('icon') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="type" class="col-md-4 control-label">{{ trans('mkeep.color') }}</label>
            <div class="col-md-6">
                {!! Form::select('color', \App\MoneyKeeper\Models\Wallet::getColorList(), Input::get('color', isset($obItem)?$obItem->color:''), array('class'=>(isset($errors) && $errors->has('color') ? 'form-control is-invalid color-selector' : 'form-control color-selector'), 'style'=>'width: 55px; height: 38px;')) !!}
                <script type="text/javascript">
                function ColorSelectInit(){
                  $('.color-selector option').each(function() {
                    $(this).css("background-color", '#'+$(this).val());
                  });
                  $('.color-selector').change(function(){
                    $(this).css("background-color", '#'+$(this).val());
                  });
                  $('.color-selector').css("background-color", '#'+$('.color-selector').val());
                };
                
                window.onload = function(){
                    ColorSelectInit();
                };
                </script>

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('color'))
                        <strong>{{ $errors->first('color') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="sort" class="col-md-4 control-label">{{ trans('mkeep.sort') }}</label>
            <div class="col-md-6">
                {!! Form::text('sort', Input::get('sort', isset($obItem)?$obItem->sort:''), array('class'=>(isset($errors) && $errors->has('sort') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('sort'))
                        <strong>{{ $errors->first('sort') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="start" class="col-md-4 control-label">{{ trans('mkeep.start') }}</label>
            <div class="col-md-6">
                {!! Form::text('start', Input::get('start', isset($obItem)?$obItem->start:''), array('class'=>(isset($errors) && $errors->has('start') ? 'form-control is-invalid' : 'form-control'))) !!}

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('start'))
                        <strong>{{ $errors->first('start') }}</strong>
                @endif
                </span>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-4"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-btn fa-save"></i> {{ trans('mkeep.save') }}
                </button>
            </div>
        </div>
    {!! Form::close() !!}
