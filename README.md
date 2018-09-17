# Simple PHP Datagrid

The intention it's just for show a simple datagrid when returning some data. 

## Example

```PHP
<?php

$fieldCustomer = new DatagridColumn();
$fieldCustomer->setBdField('type')
        ->setRowAttrClass('text-center')
        ->setLabelAttrClass("title text-center col-md-1")
        ->setLabel('Customer')
        ->setRowCond(function ($row) {
            return (strcmp('c', $row->type) === 0 ? 'Customer' : 'User');
        });

$fieldName = new DatagridColumn();
$fieldName->setBdField('name')
        ->setRowAttrClass('text-center')
        ->setLabelAttrClass("title text-center")
        ->setLabel('Name')
        ->setRowCond(function ($row) {
           return $row->name; 
        });

$fieldEmail = new DatagridColumn();
$fieldEmail->setBdField('email')
        ->setRowAttrClass('text-center')
        ->setLabelAttrClass("title text-center")
        ->setLabel('Email')
        ->setRowCond(function ($row) {
           return $row->email; 
        });

$fieldCreatedAt = new DatagridColumn();
$fieldCreatedAt->setBdField('created_at')
        ->setRowAttrClass('text-center')
        ->setLabelAttrClass("title text-center")
        ->setLabel('Created at')
        ->setRowCond(function ($row) {
            return DateUtils::ConvertDateFromDB($row->created_at);
        });

$fieldActionEdit = new DatagridColumn();
$fieldActionEdit->setIsSortable(false)
        ->setIsAction(true)
        ->setRowAttrClass('text-center')
        ->setLabelAttrClass("title text-center col-md-1")
        ->setLabel('Edit')
        ->setRowCond(function ($row) {
            $link = '/form/?action=edit&amp;id=' . $row->id;
            return str_replace(array('%link%', '%title%'), array($link, 'Edit'), \DatagridHtmlTemplate::BTN_ACTION_EDIT);
        });

$fieldActionRemove = new DatagridColumn();
$fieldActionRemove->setIsSortable(false)
        ->setIsAction(true)
        ->setRowAttrClass('text-center')
        ->setLabelAttrClass("title text-center  col-md-1")
        ->setLabel('Remove')
        ->setRowCond(function ($row) {
            $link = '/form/?action=remove&amp;id=' . $row->id;
            return str_replace(array('%link%', '%title%'), array($link, 'Remove'), \DatagridHtmlTemplate::BTN_ACTION_REMOVE);
        });

$datagrid = new Datagrid();
$datagrid->setData($foundObjects)
        ->addColumn($fieldCustomer)
        ->addColumn($fieldName)
        ->addColumn($fieldEmail)
        ->addColumn($fieldCreatedAt)
        ->addColumn($fieldActionEdit)
        ->addColumn($fieldActionRemove);
```

