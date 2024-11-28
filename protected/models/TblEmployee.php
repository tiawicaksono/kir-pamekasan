<?php

/**
 * This is the model class for table "tbl_employee".
 *
 * The followings are the available columns in table 'tbl_employee':
 * @property integer $employee_id
 * @property string $employee_name
 * @property string $join_date
 * @property string $birth_date
 * @property string $employee_address
 * @property integer $employee_status
 */
class TblEmployee extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_employee';
    }
    
    public function primaryKey() {
        return array('employee_id');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('employee_status', 'numerical', 'integerOnly' => true),
            array('employee_name', 'length', 'max' => 100),
            array('join_date, birth_date, employee_address', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('employee_id, employee_name, join_date, birth_date, employee_address, employee_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'employee_id' => 'Employee',
            'employee_name' => 'Employee Name',
            'join_date' => 'Join Date',
            'birth_date' => 'Birth Date',
            'employee_address' => 'Employee Address',
            'employee_status' => 'Employee Status',
//            'job_id' => 'Job',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('employee_name', $this->employee_name, true);
        $criteria->compare('join_date', $this->join_date, true);
        $criteria->compare('birth_date', $this->birth_date, true);
        $criteria->compare('employee_address', $this->employee_address, true);
        $criteria->compare('employee_status', $this->employee_status);
//        $criteria->compare('job_id', $this->job_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TblEmployee the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function employeeHome() {
        $criteria = new CDbCriteria();
        $criteria->addNotInCondition('employee_id', array(1));
        $criteria->addInCondition('employee_status', array(1));
        $criteria->order = 'employee_id ASC';
        $criteria->limit = 13;
        return $this->findAll($criteria);
    }
    
    public function employeeActive() {
        return $this->findAllByAttributes(array('employee_status' => 1));
    }
}
