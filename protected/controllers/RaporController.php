<?php

class RaporController extends MyController
{
	public function actionIndex()
	{
		$this->render('index');
	}
        public function actionViewByGuru(){
            $tahunAjaran= TahunAjaran::model()->getTahunAjaranAktif();
            $userId     = Yii::app()->user->getUserId();
            $guru       = Guru::model()->findByAttributes(array('id_user'=>$userId));
            $kelasAktif = KelasAktif::model()->findByAttributes(array('id_guru_walikelas'=>$guru->id,'id_tahun_ajaran'=>$tahunAjaran['id']));
            $data['kelasAktif']= KelasAktif::model()->getKelasAktif($kelasAktif->id);
            $data['siswaList'] = Siswa::model()->getSiswaByKelasAktif($kelasAktif->id);
            $data['id_kelas_aktif']=$kelasAktif->id;
            $this->render('viewByGuru',$data);
            
        }
        public function actionEditRapor($id_siswa,$id_kelas_aktif){
            $data['rapor']              =  Rapor::model()->getRaporSiswa($id_siswa,$id_kelas_aktif);
            if($_POST){
                $is_success= Rapor::model()->saveRaporSiswa($data['rapor']['id'],$_POST);
                $this->notice($is_success, 'Rapor Siswa', 'update');
            }
            $data['rapor']              =  Rapor::model()->getRaporSiswa($id_siswa,$id_kelas_aktif);
            $data['ekstrakurikulerList']=  Ekstrakurikuler::model()->findAll();
            $data['siswa']              =  Siswa::model()->findByPk($id_siswa);
            $data['kelas']              =  KelasAktif::model()->getKelasAktif($id_kelas_aktif);
            $data['absenSiswa']         =  Absen::model()->getRekapitulasiAbsenSiswaByRapor($data['rapor']['id']);
//            if($data['rapor']['ijin']===null){
//                $data['rapor']['ijin']=$data['absenSiswa']['ijin'];
//                $data['rapor']['sakit']=$data['absenSiswa']['sakit'];
//                $data['rapor']['alpha']=$data['absenSiswa']['alpha'];
//            }
            $this->render("editRapor",$data);
        }
}