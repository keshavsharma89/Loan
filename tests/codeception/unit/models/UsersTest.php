<?php
namespace tests\models;
use app\models\Users;

class UsersTest extends \Codeception\Test\Unit
{
	/**
     * @var \
     */
    protected $model;

    protected function _before()
    {
    }

    protected function _after()
    {
    }
	
    // This function is to test the add new record script with the correct details
    public function testCorrectAge()
    {
        $model= new Users([ 
			'personalCode' => 49005025465
        ]);
        
        $correctage=27;
        expect_that($correctage==$model->getAge());
    }

}
