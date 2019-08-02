<?php

namespace backend\controllers;

use Yii;
use backend\models\Authitem;
use backend\models\AuthitemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AuthitemController implements the CRUD actions for Authitem model.
 */
class AuthitemController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                    [
                        'allow'=>true,
                        'actions'=>['index','create','update','view','resetpassword','managerule'],
                        'roles'=>['@'],
                    ],
                    [
                        'allow'=>true,
                        'actions'=>['delete'],
                        'roles'=>['System Administrator'],
                    ]

                ]
            ]
        ];
    }

    /**
     * Lists all Authitem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new AuthitemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Authitem model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Authitem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Authitem();

        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;
            //$auth->removeAll();

            $newrole = $auth->createRole($model->name);
            $newrole->description = $model->description;
            $newrole->type = $model->type;
            $auth->add($newrole);


                $session = Yii::$app->session;
                $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Authitem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelchild = \backend\models\Auhtitemchild::find()->where(['parent'=>$model->name])->all();

        if ($model->load(Yii::$app->request->post())) {

            $childlist = $model->child_list;
           // echo $model->name;return;

          //  print_r($childlist);return;

            $auth = Yii::$app->authManager;
            $olditem = $auth->getRole($model->name);
            $olditem->description = $model->description;
            $olditem->type = $model->type;

            $auth->update($model->name,$olditem);

            if(sizeof($childlist)>0){
               for($i=0;$i<=count($childlist)-1;$i++){
                   //echo $childlist[$i];return;
                   $childitem = $auth->getRole($childlist[$i]);
                   $auth->addChild($olditem,$childitem);
               }

            }

            $session = Yii::$app->session;
            $session->setFlash('msg','บันทึกรายการเรียบร้อย');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'modelchild'=> $modelchild,
        ]);
    }

    /**
     * Deletes an existing Authitem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteRecord', ['user_id' => Yii::$app->user->id])) {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }else{

        }

    }

    /**
     * Finds the Authitem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Authitem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Authitem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionManagerule(){

        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $rule = new \common\rbac\DeleteRecordRule(); // rule ที่สร้างไว้
        $auth->add($rule);

        // site module

//        $site_index = $auth->createPermission('site/index');
//        $auth->add($site_index);
//        $site_logout = $auth->createPermission('site/logout');
//        $auth->add($site_logout);
//        $site_login = $auth->createPermission('site/login');
//        $auth->add($site_login);
//
//        $site_permission = $auth->createPermission('sitemodule');
//        $site_permission->description = "หน้าหลัก";
//        $auth->add($site_permission);
//        $auth->addChild($site_permission,$site_index);
//        $auth->addChild($site_permission,$site_logout);

//        $suplier = $auth->createRole('Suplier');
//        $suplier->description = "Suplier";
//        $auth->add($suplier);
//        $auth->addChild($suplier,$site_permission);

        // plan_module
        $plant_index = $auth->createPermission('plant/index');
        $auth->add($plant_index);
        $plant_update = $auth->createPermission('plant/update');
        $auth->add($plant_update);
        $plant_delete = $auth->createPermission('plant/delete');
        $auth->add($plant_delete);
        $plant_view = $auth->createPermission('plant/view');
        $auth->add($plant_view);
        $plant_create = $auth->createPermission('plant/create');
        $auth->add($plant_create);
        $plant_deletelogo = $auth->createPermission('plant/deletelogo');
        $auth->add($plant_deletelogo);

        $plant_permission = $auth->createPermission('plantmodule');
        $plant_permission->description = "สิทธิ์ใช้งานโมดูล Plant";
        $auth->add($plant_permission);

        $auth->addChild($plant_permission,$plant_index);
        $auth->addChild($plant_permission,$plant_view);
        $auth->addChild($plant_permission,$plant_update);
        $auth->addChild($plant_permission,$plant_delete);
        $auth->addChild($plant_permission,$plant_create);
        $auth->addChild($plant_permission,$plant_deletelogo);

        $manage_plant = $auth->createRole('จัดการข้อมูลบริษัท');
        $manage_plant->description = "Manage plant";
        $auth->add($manage_plant);
        $auth->addChild($manage_plant,$plant_permission);

        // user_module
        $user_index = $auth->createPermission('user/index');
        $auth->add($user_index);
        $user_update = $auth->createPermission('user/update');
        $auth->add($user_update);
        $user_delete = $auth->createPermission('user/delete');
        $auth->add($user_delete);
        $user_view = $auth->createPermission('user/view');
        $auth->add($user_view);
        $user_create = $auth->createPermission('user/create');
        $auth->add($user_create);

        $user_permission = $auth->createPermission('usermodule');
        $user_permission->description = "สิทธิ์ใช้งานโมดูล Plant";
        $auth->add($user_permission);

        $auth->addChild($user_permission,$user_index);
        $auth->addChild($user_permission,$user_view);
        $auth->addChild($user_permission,$user_update);
        $auth->addChild($user_permission,$user_delete);
        $auth->addChild($user_permission,$user_create);

        $manage_user = $auth->createRole('จัดการข้อมูลผู้ใช้งาน');
        $manage_user->description = "Manage user";
        $auth->add($manage_user);
        $auth->addChild($manage_user,$user_permission);

        // usergroup_module
        $usergroup_index = $auth->createPermission('usergroup/index');
        $auth->add($usergroup_index);
        $usergroup_update = $auth->createPermission('usergroup/update');
        $auth->add($usergroup_update);
        $usergroup_delete = $auth->createPermission('usergroup/delete');
        $auth->add($usergroup_delete);
        $usergroup_view = $auth->createPermission('usergroup/view');
        $auth->add($usergroup_view);
        $usergroup_create = $auth->createPermission('usergroup/create');
        $auth->add($usergroup_create);

        $usergroup_permission = $auth->createPermission('usergroupmodule');
        $usergroup_permission->description = "สิทธิ์ใช้งานโมดูล Plant";
        $auth->add($usergroup_permission);

        $auth->addChild($usergroup_permission,$usergroup_index);
        $auth->addChild($usergroup_permission,$usergroup_view);
        $auth->addChild($usergroup_permission,$usergroup_update);
        $auth->addChild($usergroup_permission,$usergroup_delete);
        $auth->addChild($usergroup_permission,$usergroup_create);

        $manage_usergroup = $auth->createRole('จัดการข้อมูลกลุ่มผู้ใช้งาน');
        $manage_usergroup->description = "Manage usergroup";
        $auth->add($manage_usergroup);
        $auth->addChild($manage_usergroup,$usergroup_permission);

        // product module
        $product_index = $auth->createPermission('product/index');
        $auth->add($product_index);
        $product_update = $auth->createPermission('product/update');
        $auth->add($product_update);
        $product_delete = $auth->createPermission('product/delete');
        $auth->add($product_delete);
        $product_view = $auth->createPermission('product/view');
        $auth->add($product_view);
        $product_create = $auth->createPermission('product/create');
        $auth->add($product_create);
        $product_photo_del = $auth->createPermission('product/deletephoto');
        $auth->add($product_photo_del);
        $product_del_all = $auth->createPermission('product/delete-all');
        $auth->add($product_del_all);
        $product_search = $auth->createPermission('product/searchitem');
        $auth->add($product_search);


        $product_import = $auth->createPermission('product/importproduct');
        $auth->add($product_import);
        $product_import_update = $auth->createPermission('product/importupdate');
        $auth->add($product_import_update);

        $product_permission = $auth->createPermission('productmodule');
        $product_permission->description = "สิทธิ์ใช้งานโมดูล product";
        $auth->add($product_permission);

        $auth->addChild($product_permission,$product_index);
        $auth->addChild($product_permission,$product_view);
        $auth->addChild($product_permission,$product_update);
        $auth->addChild($product_permission,$product_delete);
        $auth->addChild($product_permission,$product_create);
        $auth->addChild($product_permission,$product_import);
        $auth->addChild($product_permission,$product_import_update);
        $auth->addChild($product_permission,$product_photo_del);
        $auth->addChild($product_permission,$product_del_all);
        $auth->addChild($product_permission,$product_search);

        $manage_product = $auth->createRole('จัดการข้อมูลสินค้า');
        $manage_product->description = "Manage Product";
        $auth->add($manage_product);
        $auth->addChild($manage_product,$product_permission);

        //work schedule module


        //invoice module
        $invoice_index = $auth->createPermission('invoice/index');
        $auth->add($invoice_index);
        $invoice_update = $auth->createPermission('invoice/update');
        $auth->add($invoice_update);
        $invoice_delete = $auth->createPermission('invoice/delete');
        $auth->add($invoice_delete);
        $invoice_view = $auth->createPermission('invoice/view');
        $auth->add($invoice_view);
        $invoice_bill = $auth->createPermission('invoice/bill');
        $auth->add($invoice_bill);
        $invoice_create = $auth->createPermission('invoice/create');
        $auth->add($invoice_create);

        $invoice_permission = $auth->createPermission('invoicemodule');
        $invoice_permission->description = "สิทธิ์ใช้งานโมดูล invoice";
        $auth->add($invoice_permission);

        $auth->addChild($invoice_permission,$invoice_index);
        $auth->addChild($invoice_permission,$invoice_view);
        $auth->addChild($invoice_permission,$invoice_update);
        $auth->addChild($invoice_permission,$invoice_delete);
        $auth->addChild($invoice_permission,$invoice_bill);
        $auth->addChild($invoice_permission,$invoice_create);

        $manage_invoice = $auth->createRole('จัดการใบเรียกเก็บเงิน');
        $manage_invoice->description = "Manage invoice";
        $auth->add($manage_invoice);
        $auth->addChild($manage_invoice,$invoice_permission);

        //employee module
        $employee_index = $auth->createPermission('employee/index');
        $auth->add($employee_index);
        $employee_update = $auth->createPermission('employee/update');
        $auth->add($employee_update);
        $employee_delete = $auth->createPermission('employee/delete');
        $auth->add($employee_delete);
        $employee_view = $auth->createPermission('employee/view');
        $auth->add($employee_view);
        $employee_create = $auth->createPermission('employee/create');
        $auth->add($employee_create);

        $employee_permission = $auth->createPermission('employeemodule');
        $employee_permission->description = "สิทธิ์ใช้งานโมดูล employee";
        $auth->add($employee_permission);

        $auth->addChild($employee_permission,$employee_index);
        $auth->addChild($employee_permission,$employee_view);
        $auth->addChild($employee_permission,$employee_update);
        $auth->addChild($employee_permission,$employee_delete);
        $auth->addChild($employee_permission,$employee_create);

        $manage_employee = $auth->createRole('จัดการข้อมูลพนักงาน');
        $manage_employee->description = "Manage invoice";
        $auth->add($manage_employee);
        $auth->addChild($manage_employee,$employee_permission);

        //product group module
        $productcategory_index = $auth->createPermission('productcategory/index');
        $auth->add($productcategory_index);
        $productcategory_update = $auth->createPermission('productcategory/update');
        $auth->add($productcategory_update);
        $productcategory_delete = $auth->createPermission('productcategory/delete');
        $auth->add($productcategory_delete);
        $productcategory_view = $auth->createPermission('productcategory/view');
        $auth->add($productcategory_view);
        $productcategory_create = $auth->createPermission('productcategory/create');
        $auth->add($productcategory_create);

        $productcategory_permission = $auth->createPermission('productcategorymodule');
        $productcategory_permission->description = "สิทธิ์ใช้งานโมดูล productcategory";
        $auth->add($productcategory_permission);

        $auth->addChild($productcategory_permission,$productcategory_index);
        $auth->addChild($productcategory_permission,$productcategory_view);
        $auth->addChild($productcategory_permission,$productcategory_update);
        $auth->addChild($productcategory_permission,$productcategory_delete);
        $auth->addChild($productcategory_permission,$productcategory_create);

        $manage_productcategory = $auth->createRole('จัดการข้อมูลกลุ่มสินค้า');
        $manage_productcategory->description = "Manage product category";
        $auth->add($manage_productcategory);
        $auth->addChild($manage_productcategory,$productcategory_permission);

        //product unit module
        $unit_index = $auth->createPermission('unit/index');
        $auth->add($unit_index);
        $unit_update = $auth->createPermission('unit/update');
        $auth->add($unit_update);
        $unit_delete = $auth->createPermission('unit/delete');
        $auth->add($unit_delete);
        $unit_view = $auth->createPermission('unit/view');
        $auth->add($unit_view);
        $unit_create = $auth->createPermission('unit/create');
        $auth->add($unit_create);

        $unit_permission = $auth->createPermission('unitmodule');
        $unit_permission->description = "สิทธิ์ใช้งานโมดูล unit";
        $auth->add($unit_permission);

        $auth->addChild($unit_permission,$unit_index);
        $auth->addChild($unit_permission,$unit_view);
        $auth->addChild($unit_permission,$unit_update);
        $auth->addChild($unit_permission,$unit_delete);
        $auth->addChild($unit_permission,$unit_create);

        $manage_unit = $auth->createRole('จัดการข้อมูลหน่วยนับ');
        $manage_unit->description = "Manage unit";
        $auth->add($manage_unit);
        $auth->addChild($manage_unit,$unit_permission);

        //message module
        $message_index = $auth->createPermission('message/index');
        $auth->add($message_index);
        $message_update = $auth->createPermission('message/update');
        $auth->add($message_update);
        $message_delete = $auth->createPermission('message/delete');
        $auth->add($message_delete);
        $message_view = $auth->createPermission('message/view');
        $auth->add($message_view);
        $message_create = $auth->createPermission('message/create');
        $auth->add($message_create);

        $message_permission = $auth->createPermission('messagemodule');
        $message_permission->description = "สิทธิ์ใช้งานโมดูล message";
        $auth->add($message_permission);

        $auth->addChild($message_permission,$message_index);
        $auth->addChild($message_permission,$message_view);
        $auth->addChild($message_permission,$message_update);
        $auth->addChild($message_permission,$message_delete);
        $auth->addChild($message_permission,$message_create);

        $manage_message = $auth->createRole('จัดการการแจ้งเตือน');
        $manage_message->description = "Manage message";
        $auth->add($manage_message);
        $auth->addChild($manage_message,$message_permission);

        //warehouse module
        $warehouse_index = $auth->createPermission('warehouse/index');
        $auth->add($warehouse_index);
        $warehouse_update = $auth->createPermission('warehouse/update');
        $auth->add($warehouse_update);
        $warehouse_delete = $auth->createPermission('warehouse/delete');
        $auth->add($warehouse_delete);
        $warehouse_view = $auth->createPermission('warehouse/view');
        $auth->add($warehouse_view);
         $warehouse_create = $auth->createPermission('warehouse/create');
        $auth->add($warehouse_create);

        $warehouse_permission = $auth->createPermission('warehousemodule');
        $warehouse_permission->description = "สิทธิ์ใช้งานโมดูล warehouse";
        $auth->add($warehouse_permission);

        $auth->addChild($warehouse_permission,$warehouse_index);
        $auth->addChild($warehouse_permission,$warehouse_view);
        $auth->addChild($warehouse_permission,$warehouse_update);
        $auth->addChild($warehouse_permission,$warehouse_delete);
        $auth->addChild($warehouse_permission,$warehouse_create);

        $manage_warehouse = $auth->createRole('จัดกาข้อมูลคลังสินค้า');
        $manage_warehouse->description = "Manage warehouse";
        $auth->add($manage_warehouse);
        $auth->addChild($manage_warehouse,$warehouse_permission);

        //customergroup module
        $customergroup_index = $auth->createPermission('customergroup/index');
        $auth->add($customergroup_index);
        $customergroup_update = $auth->createPermission('customergroup/update');
        $auth->add($customergroup_update);
        $customergroup_delete = $auth->createPermission('customergroup/delete');
        $auth->add($customergroup_delete);
        $customergroup_view = $auth->createPermission('customergroup/view');
        $auth->add($customergroup_view);
        $customergroup_create = $auth->createPermission('customergroup/create');
        $auth->add($customergroup_create);

        $customergroup_permission = $auth->createPermission('customergroupmodule');
        $customergroup_permission->description = "สิทธิ์ใช้งานโมดูล customergroup";
        $auth->add($customergroup_permission);

        $auth->addChild($customergroup_permission,$customergroup_index);
        $auth->addChild($customergroup_permission,$customergroup_view);
        $auth->addChild($customergroup_permission,$customergroup_update);
        $auth->addChild($customergroup_permission,$customergroup_delete);
        $auth->addChild($customergroup_permission,$customergroup_create);

        $manage_customergroup = $auth->createRole('จัดกาข้อมูลกลุ่มสินค้า');
        $manage_customergroup->description = "Manage customergroup";
        $auth->add($manage_customergroup);
        $auth->addChild($manage_customergroup,$customergroup_permission);

        //customer module
        $customer_index = $auth->createPermission('customer/index');
        $auth->add($customer_index);
        $customer_update = $auth->createPermission('customer/update');
        $auth->add($customer_update);
        $customer_delete = $auth->createPermission('customer/delete');
        $auth->add($customer_delete);
        $customer_view = $auth->createPermission('customer/view');
        $auth->add($customer_view);
        $customer_create = $auth->createPermission('customer/create');
        $auth->add($customer_create);

        $customer_permission = $auth->createPermission('customermodule');
        $customer_permission->description = "สิทธิ์ใช้งานโมดูล customer";
        $auth->add($customer_permission);

        $auth->addChild($customer_permission,$customer_index);
        $auth->addChild($customer_permission,$customer_view);
        $auth->addChild($customer_permission,$customer_update);
        $auth->addChild($customer_permission,$customer_delete);
        $auth->addChild($customer_permission,$customer_create);

        $manage_customer = $auth->createRole('จัดกาข้อมูลลูกค้า');
        $manage_customer->description = "Manage customer";
        $auth->add($manage_customer);
        $auth->addChild($manage_customer,$customer_permission);

        //quotation module
        $quotation_index = $auth->createPermission('quotation/index');
        $auth->add($quotation_index);
        $quotation_update = $auth->createPermission('quotation/update');
        $auth->add($quotation_update);
        $quotation_delete = $auth->createPermission('quotation/delete');
        $auth->add($quotation_delete);
        $quotation_view = $auth->createPermission('quotation/view');
        $auth->add($quotation_view);
        $quotation_create = $auth->createPermission('quotation/create');
        $auth->add($quotation_create);
        $quotation_firmorder = $auth->createPermission('quotation/firmorder');
        $auth->add($quotation_firmorder);

        $quotation_permission = $auth->createPermission('quotationmodule');
        $quotation_permission->description = "สิทธิ์ใช้งานโมดูล quotation";
        $auth->add($quotation_permission);

        $auth->addChild($quotation_permission,$quotation_index);
        $auth->addChild($quotation_permission,$quotation_view);
        $auth->addChild($quotation_permission,$quotation_update);
        $auth->addChild($quotation_permission,$quotation_delete);
        $auth->addChild($quotation_permission,$quotation_create);
        $auth->addChild($quotation_permission,$quotation_firmorder);

        $manage_quotation = $auth->createRole('จัดกาข้อมูลใบเสนอราคา');
        $manage_quotation->description = "Manage quotation";
        $auth->add($manage_quotation);
        $auth->addChild($manage_quotation,$quotation_permission);

        //sale module
        $sale_index = $auth->createPermission('sale/index');
        $auth->add($sale_index);
        $sale_update = $auth->createPermission('sale/update');
        $auth->add($sale_update);
        $sale_delete = $auth->createPermission('sale/delete');
        $auth->add($sale_delete);
        $sale_view = $auth->createPermission('sale/view');
        $auth->add($sale_view);
        $sale_create = $auth->createPermission('sale/create');
        $auth->add($sale_create);
        $sale_payment = $auth->createPermission('sale/payment');
        $auth->add($sale_payment);

        $sale_permission = $auth->createPermission('salemodule');
        $sale_permission->description = "สิทธิ์ใช้งานโมดูล sale";
        $auth->add($sale_permission);

        $auth->addChild($sale_permission,$sale_index);
        $auth->addChild($sale_permission,$sale_view);
        $auth->addChild($sale_permission,$sale_update);
        $auth->addChild($sale_permission,$sale_delete);
        $auth->addChild($sale_permission,$sale_create);
        $auth->addChild($sale_permission,$sale_payment);

        $manage_sale = $auth->createRole('จัดกาข้อมูลใบสั่งซื้อ');
        $manage_sale->description = "Manage sale";
        $auth->add($manage_sale);
        $auth->addChild($manage_sale,$sale_permission);

        //db manager
        $db_index = $auth->createPermission('db-manager');
        $auth->add($db_index);

        $bakup_permission = $auth->createPermission('backupmodule');
        $bakup_permission->description = "สิทธิ์ใช้งานโมดูล bakup_permission";
        $auth->add($bakup_permission);

        $manage_backup = $auth->createRole('จัดการการสำรองข้อมูล');
        $manage_backup->description = "Manage backup";
        $auth->add($manage_backup);

        $auth->addChild($manage_backup,$bakup_permission);



        $admin_role = $auth->createRole('System Administrator');
        $admin_role->description = "ผู้ดูแลระบบ";
        $auth->add($admin_role);

        $auth->addChild($admin_role,$manage_plant);
        $auth->addChild($admin_role,$manage_user);
        $auth->addChild($admin_role,$manage_usergroup);
        $auth->addChild($admin_role,$manage_product);
        $auth->addChild($admin_role,$manage_invoice);
        $auth->addChild($admin_role,$manage_productcategory);
        $auth->addChild($admin_role,$manage_unit);
        $auth->addChild($admin_role,$manage_employee);
        $auth->addChild($admin_role,$manage_message);
        $auth->addChild($admin_role,$manage_warehouse);
        $auth->addChild($admin_role,$manage_customergroup);
        $auth->addChild($admin_role,$manage_customer);
        $auth->addChild($admin_role,$manage_quotation);
        $auth->addChild($admin_role,$manage_sale);
        $auth->addChild($admin_role,$manage_backup);

        $user_role = $auth->createRole('System User');
        $user_role->description = "ผู้ใช้งานทั่วไป";
        $auth->add($user_role);


        $auth->addChild($user_role,$manage_product);


        $auth->assign($admin_role,2);
        $auth->assign($user_role,2);






    }
}
/*
 *
 public function init()
    {
      $auth = Yii::$app->authManager;
      $auth->removeAll();
      Console::output('Removing All! RBAC.....');

      $createPost = $auth->createPermission('createBlog');
      $createPost->description = 'สร้าง blog';
      $auth->add($createPost);

      $updatePost = $auth->createPermission('updateBlog');
      $updatePost->description = 'แก้ไข blog';
      $auth->add($updatePost);

      // เพิ่ม permission loginToBackend <<<------------------------
      $loginToBackend = $auth->createPermission('loginToBackend');
      $loginToBackend->description = 'ล็อกอินเข้าใช้งานส่วน backend';
      $auth->add($loginToBackend);

      $manageUser = $auth->createRole('ManageUser');
      $manageUser->description = 'จัดการข้อมูลผู้ใช้งาน';
      $auth->add($manageUser);

      $author = $auth->createRole('Author');
      $author->description = 'การเขียนบทความ';
      $auth->add($author);

      $management = $auth->createRole('Management');
      $management->description = 'จัดการข้อมูลผู้ใช้งานและบทความ';
      $auth->add($management);

      $admin = $auth->createRole('Admin');
      $admin->description = 'สำหรับการดูแลระบบ';
      $auth->add($admin);

      $rule = new \common\rbac\AuthorRule;
      $auth->add($rule);

      $updateOwnPost = $auth->createPermission('updateOwnPost');
      $updateOwnPost->description = 'แก้ไขบทความตัวเอง';
      $updateOwnPost->ruleName = $rule->name;
      $auth->add($updateOwnPost);

      $auth->addChild($author,$createPost);
      $auth->addChild($updateOwnPost, $updatePost);
      $auth->addChild($author, $updateOwnPost);

      // addChild role ManageUser <<<------------------------
      $auth->addChild($manageUser, $loginToBackend);

      $auth->addChild($management, $manageUser);
      $auth->addChild($management, $author);

      $auth->addChild($admin, $management);

      $auth->assign($admin, 1);
      $auth->assign($management, 2);
      $auth->assign($author, 3);
      $auth->assign($author, 4);

      Console::output('Success! RBAC roles has been added.');
    } */
