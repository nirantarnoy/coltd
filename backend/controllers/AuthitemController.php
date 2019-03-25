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

        $manage_plant = $auth->createRole('Manage Plant');
        $manage_plant->description = "Manage plant";
        $auth->add($manage_plant);
        $auth->addChild($manage_plant,$plant_permission);

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

        $manage_product = $auth->createRole('Manage product');
        $manage_product->description = "Manage Product";
        $auth->add($manage_product);
        $auth->addChild($manage_product,$product_permission);

        //work schedule module
        $workschedule_index = $auth->createPermission('workschedule/index');
        $auth->add($workschedule_index);
        $workschedule_update = $auth->createPermission('workschedule/update');
        $auth->add($workschedule_update);
        $workschedule_delete = $auth->createPermission('workschedule/delete');
        $auth->add($workschedule_delete);
        $workschedule_view = $auth->createPermission('workschedule/view');
        $auth->add($workschedule_view);
        $workschedule_create = $auth->createPermission('workschedule/create');
        $auth->add($workschedule_create);

        $workschedule_permission = $auth->createPermission('workschedulemodule');
        $workschedule_permission->description = "สิทธิ์ใช้งานโมดูล workschedule";
        $auth->add($workschedule_permission);

        $auth->addChild($workschedule_permission,$workschedule_index);
        $auth->addChild($workschedule_permission,$workschedule_view);
        $auth->addChild($workschedule_permission,$workschedule_update);
        $auth->addChild($workschedule_permission,$workschedule_delete);
        $auth->addChild($workschedule_permission,$workschedule_create);

        $manage_workschedule = $auth->createRole('Manage workschedule');
        $manage_workschedule->description = "Manage work schedule";
        $auth->add($manage_workschedule);
        $auth->addChild($manage_workschedule,$workschedule_permission);

        //purchplan module
        $purchplan_index = $auth->createPermission('purchplan/index');
        $auth->add($purchplan_index);
        $purchplan_update = $auth->createPermission('purchplan/update');
        $auth->add($purchplan_update);
        $purchplan_delete = $auth->createPermission('purchplan/delete');
        $auth->add($purchplan_delete);
        $purchplan_view = $auth->createPermission('purchplan/view');
        $auth->add($purchplan_view);
        $purchplan_create = $auth->createPermission('purchplan/create');
        $auth->add($purchplan_create);
        $purchplan_testsave = $auth->createPermission('purchplan/testsave');
        $auth->add($purchplan_testsave);
        $purchplan_showcalendar = $auth->createPermission('purchplan/showcalendar');
        $auth->add($purchplan_showcalendar);
        $purchplan_calendaritem = $auth->createPermission('purchplan/calendaritem');
        $auth->add($purchplan_calendaritem);
        $purchplan_updateplan = $auth->createPermission('purchplan/updateplan');
        $auth->add($purchplan_updateplan);
        $purchplan_copyplan = $auth->createPermission('purchplan/copyplan');
        $auth->add($purchplan_copyplan);
        $purchplan_findevent = $auth->createPermission('purchplan/findevent');
        $auth->add($purchplan_findevent);
        $purchplan_checkoldplan = $auth->createPermission('purchplan/checkoldplan');
        $auth->add($purchplan_checkoldplan);

        $purchplan_permission = $auth->createPermission('purchplanmodule');
        $purchplan_permission->description = "สิทธิ์ใช้งานโมดูล purchplan";
        $auth->add($purchplan_permission);

        $auth->addChild($purchplan_permission,$purchplan_index);
        $auth->addChild($purchplan_permission,$purchplan_view);
        $auth->addChild($purchplan_permission,$purchplan_update);
        $auth->addChild($purchplan_permission,$purchplan_delete);
        $auth->addChild($purchplan_permission,$purchplan_create);
        $auth->addChild($purchplan_permission,$purchplan_testsave);
        $auth->addChild($purchplan_permission,$purchplan_showcalendar);
        $auth->addChild($purchplan_permission,$purchplan_calendaritem);
        $auth->addChild($purchplan_permission,$purchplan_updateplan);
        $auth->addChild($purchplan_permission,$purchplan_copyplan);
        $auth->addChild($purchplan_permission,$purchplan_findevent);
        $auth->addChild($purchplan_permission,$purchplan_checkoldplan);

        $manage_purchplan = $auth->createRole('Manage purchplan');
        $manage_purchplan->description = "Manage purchase plan";
        $auth->add($manage_purchplan);
        $auth->addChild($manage_purchplan,$purchplan_permission);

        // prodrec module
        $prodrec_index = $auth->createPermission('prodrec/index');
        $auth->add($prodrec_index);
        $prodrec_update = $auth->createPermission('prodrec/update');
        $auth->add($prodrec_update);
        $prodrec_delete = $auth->createPermission('prodrec/delete');
        $auth->add($prodrec_delete);
        $prodrec_view = $auth->createPermission('prodrec/view');
        $auth->add($prodrec_view);
        $prodrec_bill = $auth->createPermission('prodrec/bill');
        $auth->add($prodrec_bill);
        $prodrec_create = $auth->createPermission('prodrec/create');
        $auth->add($prodrec_create);
        $prodrec_cancelqc = $auth->createPermission('prodrec/cancelqc');
        $auth->add($prodrec_cancelqc);
        $prodrec_createinv = $auth->createPermission('prodrec/createinv');
        $auth->add($prodrec_createinv);

        $prodrec_permission = $auth->createPermission('prodrecmodule');
        $prodrec_permission->description = "สิทธิ์ใช้งานโมดูล prodrec";
        $auth->add($prodrec_permission);

        $auth->addChild($prodrec_permission,$prodrec_index);
        $auth->addChild($prodrec_permission,$prodrec_view);
        $auth->addChild($prodrec_permission,$prodrec_update);
        $auth->addChild($prodrec_permission,$prodrec_delete);
        $auth->addChild($prodrec_permission,$prodrec_bill);
        $auth->addChild($prodrec_permission,$prodrec_create);
        $auth->addChild($prodrec_permission,$prodrec_cancelqc);
        $auth->addChild($prodrec_permission,$prodrec_createinv);

        $manage_prodrec = $auth->createRole('Manage prodrec');
        $manage_prodrec->description = "Manage product received";
        $auth->add($manage_prodrec);
        $auth->addChild($manage_prodrec,$prodrec_permission);

        //prodissue module
        $prodissue_index = $auth->createPermission('prodissue/index');
        $auth->add($prodissue_index);
        $prodissue_update = $auth->createPermission('prodissue/update');
        $auth->add($prodissue_update);
        $prodissue_delete = $auth->createPermission('prodissue/delete');
        $auth->add($prodissue_delete);
        $prodissue_view = $auth->createPermission('prodissue/view');
        $auth->add($prodissue_view);
        $prodissue_create = $auth->createPermission('prodissue/create');
        $auth->add($prodissue_create);
        $prodissue_showemp = $auth->createPermission('prodissue/showemp');
        $auth->add($prodissue_showemp);
        $prodissue_getzoneinfo = $auth->createPermission('prodissue/getzoneinfo');
        $auth->add($prodissue_getzoneinfo);
        $prodissue_cancel = $auth->createPermission('prodissue/cancel');
        $auth->add($prodissue_cancel);

        $prodissue_permission = $auth->createPermission('prodissuemodule');
        $prodissue_permission->description = "สิทธิ์ใช้งานโมดูล prodissue";
        $auth->add($prodissue_permission);

        $auth->addChild($prodissue_permission,$prodissue_index);
        $auth->addChild($prodissue_permission,$prodissue_view);
        $auth->addChild($prodissue_permission,$prodissue_update);
        $auth->addChild($prodissue_permission,$prodissue_delete);
        $auth->addChild($prodissue_permission,$prodissue_create);
        $auth->addChild($prodissue_permission,$prodissue_showemp);
        $auth->addChild($prodissue_permission,$prodissue_getzoneinfo);
        $auth->addChild($prodissue_permission,$prodissue_cancel);

        $manage_prodissue = $auth->createRole('Manage prodissue');
        $manage_prodissue->description = "Manage product issue";
        $auth->add($manage_prodissue);
        $auth->addChild($manage_prodissue,$prodissue_permission);

        //productionrec module
        $productionrec_index = $auth->createPermission('productionrec/index');
        $auth->add($productionrec_index);
        $productionrec_update = $auth->createPermission('productionrec/update');
        $auth->add($productionrec_update);
        $productionrec_delete = $auth->createPermission('productionrec/delete');
        $auth->add($productionrec_delete);
        $productionrec_view = $auth->createPermission('productionrec/view');
        $auth->add($productionrec_view);
        $productionrec_print = $auth->createPermission('productionrec/print');
        $auth->add($productionrec_print);
        $productionrec_create = $auth->createPermission('productionrec/create');
        $auth->add($productionrec_create);
        $productionrec_findemp = $auth->createPermission('productionrec/findemp');
        $auth->add($productionrec_findemp);
        $productionrec_findzonedate = $auth->createPermission('productionrec/findzonedate');
        $auth->add($productionrec_findzonedate);
        $productionrec_finditem = $auth->createPermission('productionrec/finditem');
        $auth->add($productionrec_finditem);

        $productionrec_permission = $auth->createPermission('productionrecmodule');
        $productionrec_permission->description = "สิทธิ์ใช้งานโมดูล productionrec";
        $auth->add($productionrec_permission);

        $auth->addChild($productionrec_permission,$productionrec_index);
        $auth->addChild($productionrec_permission,$productionrec_view);
        $auth->addChild($productionrec_permission,$productionrec_update);
        $auth->addChild($productionrec_permission,$productionrec_delete);
        $auth->addChild($productionrec_permission,$productionrec_create);
        $auth->addChild($productionrec_permission,$productionrec_print);
        $auth->addChild($productionrec_permission,$productionrec_findemp);
        $auth->addChild($productionrec_permission,$productionrec_findzonedate);
        $auth->addChild($productionrec_permission,$productionrec_finditem);

        $manage_productionrec = $auth->createRole('Manage productionrec');
        $manage_productionrec->description = "Manage production received";
        $auth->add($manage_productionrec);
        $auth->addChild($manage_productionrec,$productionrec_permission);

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

        $manage_invoice = $auth->createRole('Manage invoice');
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

        $manage_employee = $auth->createRole('Manage employee');
        $manage_employee->description = "Manage invoice";
        $auth->add($manage_employee);
        $auth->addChild($manage_employee,$employee_permission);

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

        $manage_message = $auth->createRole('Manage message');
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

        $manage_warehouse = $auth->createRole('Manage warehouse');
        $manage_warehouse->description = "Manage warehouse";
        $auth->add($manage_warehouse);
        $auth->addChild($manage_warehouse,$warehouse_permission);

        //db manager
        $db_index = $auth->createPermission('db-manager');
        $auth->add($db_index);

        $bakup_permission = $auth->createPermission('backupmodule');
        $bakup_permission->description = "สิทธิ์ใช้งานโมดูล bakup_permission";
        $auth->add($bakup_permission);

        $manage_backup = $auth->createRole('Manage backup');
        $manage_backup->description = "Manage backup";
        $auth->add($manage_backup);

        $auth->addChild($manage_backup,$bakup_permission);



        $admin_role = $auth->createRole('System Administrator');
        $admin_role->description = "ผู้ดูแลระบบ";
        $auth->add($admin_role);

        $auth->addChild($admin_role,$manage_plant);
        $auth->addChild($admin_role,$manage_product);
        $auth->addChild($admin_role,$manage_prodrec);
        $auth->addChild($admin_role,$manage_prodissue);
        $auth->addChild($admin_role,$manage_productionrec);
        $auth->addChild($admin_role,$manage_purchplan);
        $auth->addChild($admin_role,$manage_invoice);
        $auth->addChild($admin_role,$manage_workschedule);
        $auth->addChild($admin_role,$manage_employee);
        $auth->addChild($admin_role,$manage_message);
        $auth->addChild($admin_role,$manage_warehouse);
        $auth->addChild($admin_role,$manage_backup);

        $user_role = $auth->createRole('System User');
        $user_role->description = "ผู้ใช้งานทั่วไป";
        $auth->add($user_role);


        $auth->addChild($user_role,$manage_product);
        $auth->addChild($user_role,$manage_prodrec);
        $auth->addChild($user_role,$manage_productionrec);


        $auth->assign($admin_role,3);
        $auth->assign($user_role,1);






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
