<?php

/**
 * This is the model class for table "tingkat_kelas".
 *
 * The followings are the available columns in table 'tingkat_kelas':
 * @property integer $id
 * @property string $nama
 *
 * The followings are the available model relations:
 * @property Kelas[] $kelases
 * @property Siswa[] $siswas
 */
class TingkatKelas extends MyCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TingkatKelas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tingkat_kelas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama', 'required'),
			array('nama', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nama', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'kelases' => array(self::HAS_MANY, 'Kelas', 'id_tingkat_kelas'),
			'siswas' => array(self::HAS_MANY, 'Siswa', 'id_tingkat_kelas_diterima'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nama' => 'Nama',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nama',$this->nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function dropdownModel($data=array()){
            if(count($data)==0){
                $data=$this->findAll();
            }
            $result=array();
            foreach($data as $d){
                $result[$d['id']]=$d['nama'];
            }
            return $result;
        }
}