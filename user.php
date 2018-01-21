<?php
    /* Template name: User*/   
    include 'config.php';
    class User {

        private $pdo;
        private $email;
        private $pemail;
        private $code;
        private $fname;
        private $lname;
        private $phone;
        private $grade;
        private $id;

        public function __construct($code, $pdo){
            $sql = "SELECT * FROM users WHERE confirm_code = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$code]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->pdo = $pdo;
            $this->code = $code;
            $this->email = $user['email'];
            $this->pemail = $user['parent_email'];
            $this->fname = $user['fname'];
            $this->lname = $user['lname'];
            $this->phone = $user['phone_number'];
            $this->grade = $user['grade'];
            $this->id = $user['id'];
        }

        public function getFname(){
            return $this->fname;
        }

        public function getLname(){
            return $this->lname;
        }

        public function getGrade(){
            return $this->grade;
        }

        public function getEmail(){
            return $this->email;
        }

        public function getPemail(){
            return $this->pemail;
        }

        public function getSubjects(){
            $stmt = $this->pdo->query("SELECT * FROM subjects");
            $subjects = array();
            while($row = $stmt->fetch()){
                if($row['client_id'] == $this->id){
                    array_push($subjects, $row);
                }
            }

            return $subjects;
        }

        public function getTutors(){
            $subs = $this->getSubjects();
            $tutors = array();
            foreach($subs as $s){
                $sql = "SELECT * FROM tutors WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$s['tutor_id']]);
                array_push($tutors, $stmt->fetch(PDO::FETCH_ASSOC));
            }

            return $tutors;
        }

        public function getTutorInfo(){
            $tutors = $this->getTutors();
            $tInfo = array();
            foreach($tutors as $t){
                $sql = "SELECT * FROM users WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$t['user_id']]);
                array_push($tInfo, $stmt->fetch(PDO::FETCH_ASSOC));
            }

            return $tInfo;
        }

        public function searchTutors($subject){
            $tutor_subs = array();
            $tutors = array();
            $sql = "SELECT * FROM subjects WHERE name = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$subject]);
            while($t = $stmt->fetch()){
                array_push($tutor_subs, $t);
            }
            foreach($tutor_subs as $ts) {
                $sql = "SELECT * FROM tutors WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$ts['tutor_id']]);
                $tutor = $stmt->fetch(PDO::FETCH_ASSOC);
                array_push($tutors, $tutor);
            }
            return $tutors;
        }

        public function updateInfo($fname, $lname, $email, $grade){
            $this->changeName($fname, $lname);
            $this->changeEmail($email);
            $this->changeGrade($grade);
        }

        public function bond($isTutor, $sub, $tutor){
            if ($isTutor){
                return FALSE;
            } else {
                $sql = "UPDATE subjects SET client_id = ? WHERE tutor_id = ? AND name = ? AND client_id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$this->id, $tutor, $sub, 0]);
                return TRUE;
            }
        }

        public function changePass($opass, $npass){
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$this->id]);
            $passhash = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($opass, $passhash['password']) && isset($npass)){
                $pass = password_hash($npass, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password = ? WHERE id = ?";
                $this->pdo->prepare($sql)->execute([$pass, $this->id]);
            } else {
                die("<h2>Invalid information, please try again</h2>");
            }
        }

        private function changeName($fname, $lname){
            $sql = "UPDATE users SET fname = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute([$fname, $this->id]);

            $sql = "UPDATE users SET lname = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute([$lname, $this->id]);
        }

        private function changeGrade($grade){
            $sql = "UPDATE users SET grade = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute([$grade, $this->id]);
        }

        private function changeEmail($email){
            $sql = "UPDATE users SET email = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute([$email, $this->id]);
        }

        private function changePemail($pemail){
            $sql = "UPDATE users SET pemail = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute([$pemail, $this->id]);
        }

        public function popSubject($sub){
            $sql = "UPDATE subjects SET client_id = 0 WHERE name = ? AND client_id = ?";
            $this->pdo->prepare($sql)->execute([$sub, $this->id]);
        }
    }
?>
