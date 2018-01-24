<?php

    namespace Webforce3\Controlleur;

    use \DateTime;

    class Controlleur{

        private $try = 1;
        private $sleep = 1;

        protected function generateToken(){
            return substr( md5( uniqid().mt_rand() ), 0, 22 );
        }

        protected function expireToken(){
            $dateNow = new DateTime();
            $dateNow->modify("+ 1 day");
            return $dateNow->format("Y-m-d H:i:s");
        }

        
        /**
         * Envoyer le fichier vers un S3 Bucket
         * 
         * @access protected
         * @param array $file_array (Obligatoire) $_FILES tableau de fichiers à télécharger.
         * @param string $s3_chemin d'accès dans le seau S3 pour télécharger.
         * @param boolean $do_rename Définissez-la si vous voulez renommer le fichier pour éviter que les fichiers du même nom ne soient dans le seau. 
         * 
         * @return boolean|string
         * FALSE: si le fichier n'est pas téléchargé
         * Nom du fichier: si le fichier est téléchargé avec succès dans le seau s3
         * 
         */

         // Fonction upload aux serveurs AWS
        protected function uploaded_file_to_s3($file_array, $s3_path = "/", $do_rename = FALSE) {
        
            if ($s3_path == "") {
                return FALSE;
            }
            
            $s3_path = preg_replace("/(.+?)\/*$/", "\\1/", $s3_path);
        
            $new_file_name = $do_rename == TRUE ? get_new_name($file_array['name']) : $file_array['name'];
        
            $opt = array(
                'fileUpload' => $file_array['tmp_name'],
                'contentType' => mime_content_type_of_file($new_file_name),
                'acl' => AmazonS3::ACL_PUBLIC,
            );
            
            // bucket à remplir avec le vrai nom d'AWS
            do {
                $r = $app["amazon"]["s3"]->create_object($app["amazon"]["BUCKET_NAME"], $s3_path . $new_file_name, $opt);
                if ($r->isOK()) {
        
                    return $new_file_name;
                }
                sleep($this->sleep);
                $this->sleep *= 2;
            } while (++$this->try < 6);
        
            return false;
        }

        /**
         * Créez un nouveau nom unique d'un fichier en ajoutant l'horodatage courant et un nombre aléatoire.
         * 
         * @access protected
         * @param string $filename est le nom du fichier pour obtenir un nom unique
         * @return string nouveau nom unique
         * 
         */
        protected function get_new_name($filename = '') {
            $ext = get_extension($filename);
            $filename = str_replace($ext, '', $filename);
            $new_filename = '';
            $new_filename = $filename . time() . rand(1, 9999) . "." . $ext;
            return $new_filename;
        }

        /**
         * Créer un S3 Bucket
         * 
         * @access protected
         * @param string $bucket_name (Obligatoire) Nom du seau à créer.
         * @return boolean
         * 
         */
        protected function create_bucket($bucket_name = "") {
            $response = $app["amazon"]["s3"]->create_bucket($bucket_name, $app["amazon"]["AWS_REGION"]);
            if ($response->isOK()) {
                return true;
            }
            return false;
        }
    }