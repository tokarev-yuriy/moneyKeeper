   <?=Form::open(array('url' => ((isset($obItem) && $obItem->id)?$paths['update'].'/'.$obItem->id:$paths['add']), 'files' => true))?>

        <div class="row form-group">
            <label for="name" class="col-md-4 control-label"><?=trans('mkeep.name')?></label>
            <div class="col-md-6">
                <?=Form::text('name', Input::get('name', isset($obItem)?$obItem->name:''), array('class'=>(isset($errors) && $errors->has('name') ? 'form-control is-invalid' : 'form-control')))?>

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('name'))
                        <strong>{{ $errors->first('name') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="icon" class="col-md-4 control-label"><?=trans('mkeep.icon')?></label>
            <div class="col-md-6">
                <?$itemId = ((isset($obItem) && $obItem->id)?$obItem->id:0)?>
                <div id="iconselect-category-icon-<?=$itemId?>"></div>
                <?=Form::hidden('icon', Input::get('icon', isset($obItem)?$obItem->icon:''), array('id'=>'category-icon-'.$itemId))?>
                <script>
                var iconSelect<?=$itemId?>;
                var iconSelect<?=$itemId?>;

                function iconCategorySelectInit() {
                    
                    selectedText<?=$itemId?> = document.getElementById('category-icon-<?=$itemId?>');
            
                    document.getElementById("iconselect-category-icon-<?=$itemId?>").addEventListener('changed', function(e){
                       selectedText<?=$itemId?>.value = iconSelect<?=$itemId?>.getSelectedValue();
                    });
                    
                    iconSelect<?=$itemId?> = new IconSelect("iconselect-category-icon-<?=$itemId?>", {
                        'selectedIconWidth':48,
                        'selectedIconHeight':48,
                        'selectedBoxPadding':1,
                        'iconsWidth':48,
                        'iconsHeight':48,
                        'boxIconSpace':3,
                        'vectoralIconNumber':8,
                        'horizontalIconNumber':1});

                    var selectedIcon = selectedText<?=$itemId?>.value;
                    var icons = [];
                    <?foreach(Category::getCategoryIcons() as $icon=>$img):?>
                    icons.push({'iconFilePath':'<?=$img?>', 'iconValue':'<?=$icon?>'});
                    <?endforeach;?>
                    
                    iconSelect<?=$itemId?>.refresh(icons);
                    for(var i = 0; i < icons.length; i++){
                        if (icons[i].iconValue==selectedIcon) {
                            iconSelect<?=$itemId?>.setSelectedIndex(i);
                        }
                    }
                    
                    
                }
                
                window.onload = function(){
                    iconCategorySelectInit();
                };
                    
                </script>

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('icon'))
                        <strong>{{ $errors->first('icon') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="sort" class="col-md-4 control-label"><?=trans('mkeep.sort')?></label>
            <div class="col-md-6">
                <?=Form::text('sort', Input::get('sort', isset($obItem)?$obItem->sort:''), array('class'=>(isset($errors) && $errors->has('sort') ? 'form-control is-invalid' : 'form-control')))?>

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('sort'))
                        <strong>{{ $errors->first('sort') }}</strong>
                @endif
                </span>
            </div>
        </div>
        
        <div class="row form-group">
            <label for="type" class="col-md-4 control-label"><?=trans('mkeep.type')?></label>
            <div class="col-md-6">
                <?=Form::select('type', Category::getTypeList(), Input::get('type', isset($obItem)?$obItem->type:''), array('class'=>(isset($errors) && $errors->has('type') ? 'form-control is-invalid' : 'form-control')))?>

                <span class="invalid-feedback">
                @if (isset($errors) && $errors->has('type'))
                        <strong>{{ $errors->first('type') }}</strong>
                @endif
                </span>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-4"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-btn fa-save"></i> <?=trans('mkeep.save')?>
                </button>
            </div>
        </div>
    <?=Form::close();?>