<?php

namespace Dev\Theo\FileBoxBundle\Services;


class Readfile
{




	/**
	* fontion de  lecture de dossier 
	**/
public function read($path)
{

	if ($handle = opendir($path)) {
		
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $content[]= "$entry\n";

        }
    }
  

    closedir($handle);
}
else
	{
		return false;
	}
	if (!empty($content)){ // si le contenue n'est pas vide alors on le retroune 

			return $content;
		}

		else{

			return false;
		}


	
}

function create_directory($directory,$path)
{
    $create = mkdir($path."/".$directory, 0777);//cree un dossier
     
 
    return $create;
}
 
function create_file($file,$path,$extention)
{
    if ($extention!="empty")
    {
        $create = fopen($path."/".$file.$extention, "w+");//cree un fichier
    }
    else
    {
        $create = fopen($path."/".$file, "w+");//cree un fichier
    }
     
     
 
    return $create;
}
 
function rename_directory_file($path,$oldname,$newname)
{
    $test=strrchr( $oldname, '.' );
     
    if (!empty($test))
    {
        $rename= rename($path."/".$oldname,$path."/".$newname.$test);
        //renome un fichier en rajoutent son extention
         
         
    }
    else
    {
        $rename= rename($path."/".$oldname,$path."/".$newname);
        //renome un dossier
     
    }
     
 
    return $rename;
     
 
 
}
 
function open_files($path)
{
    $open = fopen($path, "r");//ouvre un dossier ou fichier
 
    return $open;

    fclose($path);
}
 
function delete_directory_file($path,$name)
{
    $direction = $path."/".$name;
    $isdir = is_dir($direction);// verifie si ces un dossier ou non
 
    if ($isdir == true)
    {
        $content = get_directory_content($direction);// on appel la premiere fonction pour recupere le contenu
        if (count($content)>2) // verifier si il y a plus de 2 element dans le dossier
        {
            foreach ($content as $key => $value)
            {
             
 
                if (strrchr( $value, '.' )) // on regarde si le fichier a un extention ex:".html"
                {
                     
                         
                        if ($value != "." && $value != "..")
                        {
                            unlink($direction.'/'.$value);
                            //delete d'un sous ficher
                        }
                         
                     
                     
                }
 
                else
                {
                     
                    delete_directory_file($direction,$value);
                     
 
                    // delete d'un sous dossier une fois qu'il a ete vide
 
                }
                 
            }
        }
        rmdir($direction);
        //delete du dossier de base une fois qu'il a ete vide
         
 
    }
    else
    {
        unlink($direction);
    }
     
}
 
function copy_dir ($dir2copy,$dir_paste)
{
     
 
        // On vérifie si $dir2copy est un dossier
        if (is_dir($dir2copy)) {
        
                // Si oui, on l'ouvre
                if ($dh = opendir($dir2copy)) {    
 
                        // On liste les dossiers et fichiers de $dir2copy
                        while (($file = readdir($dh)) !== false) {
                        
                                // Si le dossier dans lequel on veut coller n'existe pas, on le créé
                                if (!is_dir($dir_paste)) $copy = mkdir ($dir_paste, 0777);
                        
                                // S'il s'agit d'un dossier, on relance la fonction rÃ©cursive
                                if(is_dir($dir2copy.'/'.$file) && $file != '..'  && $file != '.')
                                    copy_dir ( $dir2copy.'/'.$file , $dir_paste.'/'.$file ); 
 
                                // S'il sagit d'un fichier, on le copie simplement
                                elseif($file != '..'  && $file != '.')
                                 
                                $copy =copy ( $dir2copy.'/'.$file , $dir_paste.'/'.$file );
                                        
                        }
                        
                // On ferme $dir2copy
                closedir($dh);
           
                }
                
        }
 
        else
        {
            $copy = copy ( $dir2copy, $dir_paste."(copie)" );
        } 
 
        return $copy;        
}
 
 
function move_directory_file($olddirectory,$newdirectory,$file_name)//deplacer un fichier
{
    $move = rename($olddirectory."/".$file_name, $newdirectory."/".$file_name); // deplace le fichier/dossier en changent le chemin du fichier/dossier
    return $move;
}
 
function upload($path)
{
    $fichier = $_FILES['file']['name'];
    $upload = move_uploaded_file($_FILES['file']['tmp_name'], $path."/".$fichier);
    return $upload;
}
 
function get_download ($filename)
{
    header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($filename));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filename));
                ob_clean();
                flush();
                $handle = fopen($filename, "r");
                $contents = fread($handle, filesize($filename));
                fclose($handle);                               
                exit;
}
 
function get_file_content($path,$filename)
{
    $dir = $path."/".$filename;
    $content = "";
    $open = fopen($dir, 'r');
    //Si on a réussi à ouvrir le fichier
    if ($open)
    {
        //Tant que l'on est pas à la fin du fichier
        while (!feof($open))
        {
            //On lit la ligne courante
            $text = fgets($open);
            //On l'affiche
            if (empty($content))
            {
                $content=$text;
            }
            else
            {
                $content=$content.$text;
            }
             
        }
        //On ferme le fichier
        fclose($open);
 
        return $content;
    }
}
 
 
function edit_file($path,$filename,$content)
{
        $dir = $path."/".$filename;
        $handle=fopen($dir,"w");
        fwrite ($handle, $content);
        fclose($handle);
}







}




?>