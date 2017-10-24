    <?if(!isset($arActions) || !is_array($arActions)) {
        $arActions = array();
    }?>
    
    <div class="clearfix"></div>
    
    <?if(!isset($arFilters) || !is_array($arFilters)) {
        $arFilters = array();
    }?>

    <?if(count($arFilters)>0):?>
    <div class="filter bg-light p-2 border border-2 border-bottom-0 border-dark rounded-top mt-2">
        <?=Form::open(array('class'=>'form-inline'));?>
        <?foreach($arFilters as $code=>$arFilterItem):?>
            <div class="form-group">
            <?
            switch($arFilterItem['type']) {
                case 'period':?>
                        <?=Form::input( 'date', $code.'_from', Input::get($code.'_from', date('Y-m-01')), array('class'=>'form-control'))?>
                        &nbsp;&mdash;&nbsp;
                        <?=Form::input( 'date', $code.'_to', Input::get($code.'_to', date('Y-m-d')), array('class'=>'form-control mr-2'))?>
                    <?break;
                case 'list':?>
                        <?=Form::select($code, $arFilterItem['values'], Input::get($code), array('class'=>'form-control mr-2'))?>
                    <?break;
                default:?>
                        <?=Form::text($code, Input::get($code, ''), array('class'=>'form-control mr-2'))?>
                    <?break;
            }
            ?>
            </div>
        <?endforeach;?>
        
        <button type="submit" class="btn btn-info">
            <i class="fa fa-btn fa-filter"></i> <?=trans('mkeep_tablegrid.filter')?>
        </button>
        
        <?=Form::close();?>
    </div>
    <?endif;?>
    
    
    <table class="table mt-3 table-striped table-sm">
      <thead class="thead-inverse">
        <tr>                          
        <?foreach($arHeads as $code=>$column):?>
          <?if(!is_array($column)) $column = array('title'=>$column)?>
          <th <?if(isset($column['style'])):?>style="<?=$column['style']?>"<?endif;?>><?=$column['title']?></th>
        <?endforeach?>
        <?if(count($arActions)>0):?>
          <th colspan="<?=count($arActions)?>" width="1%"><?=trans('mkeep_tablegrid.actions')?></th>
        <?endif;?>
        </tr>
      </thead>
      <tbody>
      <?foreach($arItems as $obItem):?>
        <tr>
        <?foreach($arHeads as $code=>$column):?>
          <?if(!is_array($column)) $column = array('title'=>$column)?>
          <td <?if(isset($column['style'])):?>style="<?=$column['style']?>"<?endif;?>>
            <?$value = $obItem->{$code};?>
            <?if(isset($arDictionaries) && is_array($arDictionaries) && isset($arDictionaries[$code])):?>                
                <?if(isset($arDictionaries[$code][$value])):?><?=$arDictionaries[$code][$value]?><?endif;?>
            <?else:?>
                <?=$value?>
            <?endif;?>
          </td>
        <?endforeach?>
        <?if(in_array('edit', $arActions)):?>
          <td>
            <?if(isset($obItem->editPath)):?>
            <a class="btn btn-info d-none d-md-block" data-btn-type="edit" href="<?=$obItem->editPath?>" data-title="<?=$obItem->editTitle?>"><i class="fa fa-pencil fa-lg"></i> <?=trans('mkeep_tablegrid.edit')?></a>
            <a class="btn btn-info d-md-none" data-btn-type="edit" href="<?=$obItem->editPath?>" data-title="<?=$obItem->editTitle?>"><i class="fa fa-pencil fa-lg"></i></a>
            <?endif;?>
          </td>
        <?endif;?>
        <?if(in_array('delete', $arActions)):?>
          <td>
            <?if(isset($obItem->deletePath)):?>
            <a class="btn btn-dark d-none d-md-block" data-btn-type="delete" href="<?=$obItem->deletePath?>" data-title="<?=$obItem->deleteTitle?>"><i class="fa fa-remove fa-lg"></i> <?=trans('mkeep_tablegrid.delete')?></a>
            <a class="btn btn-dark d-md-none" data-btn-type="delete" href="<?=$obItem->deletePath?>" data-title="<?=$obItem->deleteTitle?>"><i class="fa fa-remove fa-lg"></i></a>
            <?endif;?>
          </td>
        <?endif;?>
        </tr>
      <?endforeach;?>
     </tbody>
    </table>
    
    <?if(method_exists($arItems, 'links')):?>
        <nav><?=$arItems->links('widgets.paginate')?></nav>
    <?endif;?>
    
    
    <div class="modal fade" id="editModalBlock" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="<?=trans('mkeep_tablegrid.close')?>">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body"></div>
        </div>
      </div>
    </div>
    
    
    <div class="modal fade" id="deleteModalBlock" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><?=trans('mkeep_tablegrid.delete_item')?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="<?=trans('mkeep_tablegrid.close')?>">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body"><?=trans('mkeep_tablegrid.sure')?></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=trans('mkeep_tablegrid.no')?></button>
            <a class="btn btn-danger delete-btn" href="javascript: void(0);"><?=trans('mkeep_tablegrid.delete')?></a>
          </div>
        </div>
      </div>
    </div>