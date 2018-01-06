<?php


/**
 *  CRUD controller for categories view and edit
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class CategoryController extends CrudListController {

    public $modelName = 'Category';
    public $sort = array(
        'by' => 'sort',
        'order' => 'asc'
    );


    /**
     * Returns routes of CRUD operations
     * It has to be determined the path to the folowing pages:
     * index, update, delete and add
     * 
     * @return array
     */    
    protected function __getPaths () {
        return [
            'index' => '/account/categories',
            'update' => '/account/categories/update',
            'delete' => '/account/categories/delete',
            'add' => '/account/categories/add',
        ];
    }
    
    /**
     * Returns views of CRUD controller
     * It has to be determined templates of the folowing pages:
     * edit, index and form
     * 
     * @return array
     */    
    protected function __getViews () {
        return [
            'edit' => 'account.categories.edit',
            'form' => 'account.categories.edit_form',
            'index' => 'account.categories.index',
        ];
    }
    
    /**
     * Returns column titles of the list table
     * 
     * 
     * @return array (field=>title)
     */    
    protected function __getHeads () {
        return array(
                'name' => trans('mkeep.name'),
                'sort' => trans('mkeep.sort'),
                'type' => trans('mkeep.type'),
                'icon' => array('title'=>trans('mkeep.icon'), 'type'=>'image'),
            );
    }
    
    /**
     * Returns page titles
     * It has to be determined titles of the folowing pages:
     * list, add, edit and delete
     * 
     * @return array (code=>title)
     */    
    protected function __getTitles () {
        return [
            'list' => trans('mkeep.categories'),
            'add'  => trans('mkeep.add_category'),
            'edit'  => trans('mkeep.edit_category'),
            'delete'  => trans('mkeep.delete_category')
        ];
    }
    
    /**
     * Returns validators for add and edit operation
     * 
     * 
     * @return array
     */    
    protected function __getValidators () {
        return array(
              'name'=>'required|max:255',
              'type'=>'required|in:'.implode(',',array_keys(Category::getTypeList())),
              'sort'=>'required|numeric',
              'icon'=>'in:'.implode(',',array_keys(Category::getCategoryIcons())),
            );
    } 
    
    /**
     * Populate object with user's input
     * 
     * 
     * @return object
     */    
    protected function __populateItem ($obItem) {
        $obItem->name = Input::get('name');
        $obItem->type = Input::get('type');
        $obItem->sort = Input::get('sort');
        $obItem->icon = Input::get('icon');
        
        $obItem->user_id = Auth::id();
        
        return $obItem;
    }
    
    /**
     * Returns dictionaries for enum type fields
     * 
     * 
     * @return array (field=>array(code=>title))
     */      
    protected function __getDictionary () {
        return array(
            'type'=>Category::getTypeList(),
            'icon'=>Category::getCategoryIcons()
        );
    }

}
