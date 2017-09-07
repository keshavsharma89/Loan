<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Loan list';
$this->params['breadcrumbs'][] = '';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                <h2>
					<?= $this->title; ?> 
					<?= Html::a('Add new loan', ['/loan/add'], ['class'=>'btn btn-primary ']) ?>
					<?= Html::a('Add multiple loans', ['/loan/bulkadd'], ['class'=>'btn btn-primary']) ?>
				</h2>
				<div class="table-responsive">
                   <?php
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchmodel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute'=>'username',
                                'filter'=>false,
                                'label'=>'Applicant Name',
                            ],
                            'amount:text:Amount',                            
                            'interest:text:Interest',
                            'duration:text:Duration',
                            [
                                'attribute'=>'dateApplied',
                                'filter'=>false,
                                'label'=>'Date Applied',
                            ],
                            
                            'campaign:text:Campaign',
                            'status:text:Status',
                            /*'phone:text:Phone',
                            
                            [
                                'attribute'=>'isDead',
                                'filter'=>array("0"=>"Alive","1"=>"Dead"),
                            ],
                            [
                                'attribute'=>'active',
                                'filter'=>array("0"=>"Inactive","1"=>"Active"),
                            ],
                            [
                                'attribute'=>'totalLoans',
                                'filter'=>false,
                                
                            ],*/
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
