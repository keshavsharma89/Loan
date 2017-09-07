<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'User list';
$this->params['breadcrumbs'][] = '';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                <h2>
					<?= $this->title; ?> 
					<?= Html::a('Add new user', ['/user/add'], ['class'=>'btn btn-primary ']) ?>
					<?= Html::a('Add multiple users', ['/user/bulkadd'], ['class'=>'btn btn-primary']) ?>
				</h2>
				<div class="table-responsive">
                   <?php
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchmodel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'firstName:text:First Name',
                            'lastName:text:Last Name',                            
                            'email:text:Email Address',
                            'personalCode:text:Personal Code',
                            'phone:text:Phone',
                            [
                                'attribute'=>'age',
                                'filter'=>false,
                                'label'=>'Age',
                            ],
                            [
                                'attribute'=>'dead',
                                'filter'=>false,
                            ],
                            [
                                'attribute'=>'Isactive',
                                'filter'=>false,
                            ],
                            [
                                'attribute'=>'totalLoans',
                                'filter'=>false,
                                'label'=>'Number of Loans',
                            ],
                            [
								'class' => 'yii\grid\ActionColumn',
								'template'=>'{update}{delete}'
                            ],
                        ]
                    ]);
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
