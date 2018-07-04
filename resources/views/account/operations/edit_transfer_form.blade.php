{!! Form::open(array('url' => ((isset($obItem) && $obItem->id)?$paths['update'].'/'.$obItem->id:$paths['add']))) !!}

     <div class="row form-group">
         <label for="date" class="col-md-4 control-label">{{ trans('mkeep.date') }}</label>
         <div class="col-md-6">
             {!! Form::input('date', 'date', Input::get('date', isset($obItem)?$obItem->date:date('Y-m-d')), array('class'=>(isset($errors) && $errors->has('date') ? 'form-control is-invalid' : 'form-control'))) !!}

             <span class="invalid-feedback">
             @if (isset($errors) && $errors->has('date'))
               <strong>{{ $errors->first('date') }}</strong>
             @endif
             </span>
         </div>
     </div>
     
     <div class="row form-group">
         <label for="value" class="col-md-4 control-label">{{ trans('mkeep.summ') }}</label>
         <div class="col-md-6">
             {!! Form::number('value', Input::get('value', isset($obItem)?$obItem->value:''), array('class'=>(isset($errors) && $errors->has('value') ? 'form-control is-invalid' : 'form-control'))) !!}

             <span class="invalid-feedback">
             @if (isset($errors) && $errors->has('value'))
                     <strong>{{ $errors->first('value') }}</strong>
             @endif
             </span>
         </div>
     </div>
     
     <div class="row form-group">
         <label for="category_id" class="col-md-4 control-label">{{ trans('mkeep.category') }}</label>
         <div class="col-md-6">
             {!! Form::select('category_id', \App\MoneyKeeper\Models\Operation::getTypeCategories('transfer'), Input::get('category_id', isset($obItem)?$obItem->category_id:''), array('class'=>(isset($errors) && $errors->has('category_id') ? 'form-control is-invalid' : 'form-control'))) !!}

             <span class="invalid-feedback">
             @if (isset($errors) && $errors->has('category_id'))
                     <strong>{{ $errors->first('category_id') }}</strong>
             @endif
             </span>
         </div>
     </div>

     <div class="row form-group">
         <label for="comment" class="col-md-4 control-label">{{ trans('mkeep.comment') }}</label>
         <div class="col-md-6">
             {!! Form::text('comment', Input::get('comment', isset($obItem)?$obItem->comment:''), array('class'=>(isset($errors) && $errors->has('comment') ? 'form-control is-invalid' : 'form-control'))) !!}

             <span class="invalid-feedback">
             @if (isset($errors) && $errors->has('comment'))
                     <strong>{{ $errors->first('comment') }}</strong>
             @endif
             </span>
         </div>
     </div>
     
     
     <div class="row form-group">
         <label for="wallet_from_id" class="col-md-4 control-label">{{ trans('mkeep.src_wallet') }}</label>
         <div class="col-md-6">
             {!! Form::select('wallet_from_id', \App\MoneyKeeper\Models\Operation::getWallets(), Input::get('wallet_from_id', isset($obItem)?$obItem->wallet_from_id:Session::get('wallet_from_id')), array('class'=>(isset($errors) && $errors->has('wallet_from_id') ? 'form-control is-invalid' : 'form-control'))) !!}

             <span class="invalid-feedback">
             @if (isset($errors) && $errors->has('wallet_from_id'))
                     <strong>{{ $errors->first('wallet_from_id') }}</strong>
             @endif
             </span>
         </div>
     </div>
     
     <div class="row form-group">
         <label for="wallet_to_id" class="col-md-4 control-label">{{ trans('mkeep.dest_wallet') }}</label>
         <div class="col-md-6">
             {!! Form::select('wallet_to_id', \App\MoneyKeeper\Models\Operation::getWallets(), Input::get('wallet_to_id', isset($obItem)?$obItem->wallet_to_id:Session::get('wallet_to_id')), array('class'=>(isset($errors) && $errors->has('wallet_to_id') ? 'form-control is-invalid' : 'form-control'))) !!}

             <span class="invalid-feedback">
             @if (isset($errors) && $errors->has('wallet_to_id'))
                     <strong>{{ $errors->first('wallet_to_id') }}</strong>
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
