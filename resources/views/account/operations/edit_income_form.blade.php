{!! Form::open(array('url' => ((isset($obItem) && $obItem->id)?$paths['update'].'/'.$obItem->id:$paths['add']))) !!}
  <div class="form-row">
     <div class="form-group col-6">
         {!! Form::input('date', 'date', Input::get('date', isset($obItem)?$obItem->date:date('Y-m-d')), array('class'=>(isset($errors) && $errors->has('date') ? 'form-control is-invalid' : 'form-control'), 'placeholder'=>trans('mkeep.date'))) !!}

         <span class="invalid-feedback">
         @if (isset($errors) && $errors->has('date'))
           <strong>{{ $errors->first('date') }}</strong>
         @endif
         </span>
     </div>  
     
     <div class="col-6 form-group">
         {!! Form::number('value', Input::get('value', isset($obItem)?$obItem->value:''), array('class'=>(isset($errors) && $errors->has('value') ? 'form-control is-invalid' : 'form-control'), 'placeholder'=>trans('mkeep.summ'))) !!}

         <span class="invalid-feedback">
         @if (isset($errors) && $errors->has('value'))
                 <strong>{{ $errors->first('value') }}</strong>
         @endif
         </span>
     </div>
  </div>
  <div class="form-row">
     <div class="col-6 form-group">
         <label for="category_id" class="mb-0">{{ trans('mkeep.category') }}</label>
         @php
           echo \App\MoneyKeeper\Helpers\Form::dropdownSelect('category_id', \App\MoneyKeeper\Models\Operation::getTypeCategoriesWithIcons('income'), Input::get('category_id', isset($obItem)?$obItem->category_id:''), (isset($errors) && $errors->has('category_id') ? 'is-invalid' : ''));
         @endphp

         <span class="invalid-feedback">
         @if (isset($errors) && $errors->has('category_id'))
                 <strong>{{ $errors->first('category_id') }}</strong>
         @endif
         </span>
     </div>
     <div class="col-6 form-group">
         <label for="wallet_to_id" class="mb-0">{{ trans('mkeep.wallet') }}</label>
          @php
            echo \App\MoneyKeeper\Helpers\Form::dropdownSelect('wallet_to_id', \App\MoneyKeeper\Models\Operation::getWalletsWithIcons(), Input::get('wallet_to_id', isset($obItem)?$obItem->wallet_to_id:Session::get('wallet_to_id')), (isset($errors) && $errors->has('wallet_to_id') ? 'is-invalid' : ''));
          @endphp
           <span class="invalid-feedback">
           @if (isset($errors) && $errors->has('wallet_to_id'))
                   <strong>{{ $errors->first('wallet_to_id') }}</strong>
           @endif
           </span>
     </div>
  </div>

     <div class="row form-group">
         {!! Form::text('comment', Input::get('comment', isset($obItem)?$obItem->comment:''), array('class'=>(isset($errors) && $errors->has('comment') ? 'form-control is-invalid' : 'form-control'), 'placeholder'=>trans('mkeep.comment'))) !!}

         <span class="invalid-feedback">
         @if (isset($errors) && $errors->has('comment'))
                 <strong>{{ $errors->first('comment') }}</strong>
         @endif
         </span>
     </div>

     <div class="row form-group">
        <div class="col-6 pl-0">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-btn fa-save"></i> {{ trans('mkeep.save') }}
            </button>
        </div>
        <div class="col-6 pr-0">
            <button id="btn-type-drop" type="button" class="btn btn-success pull-right dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-long-arrow-right"></i>&nbsp;&nbsp;{{ trans('mkeep.add_income') }}
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">              
              <a class="dropdown-item text-danger" data-btn-type="edit" href="/account/operations/spend/{{ ((isset($obItem) && $obItem->id)?'update/'.$obItem->id:'add') }}"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;{{ trans('mkeep.add_spend') }}</a>
              <a class="dropdown-item" data-btn-type="edit" href="/account/operations/transfer/{{ ((isset($obItem) && $obItem->id)?'update/'.$obItem->id:'add') }}"><i class="fa fa-exchange"></i>&nbsp;&nbsp;{{ trans('mkeep.add_transfer') }}</a>
            </div>
        </div>
     </div>
     @include('account.operations.wallet')
 {!! Form::close() !!}
