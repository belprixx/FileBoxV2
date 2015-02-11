<?php

namespace Dev\Theo\FileBoxBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dev\Theo\FileBoxBundle\Model;



class DefaultController extends Controller
{
	

    public function indexAction()
    {

    	$path = '../test';
        

        $root['nom'] = $path;
    
        $this->get('dev_theo_file_box.params')->save(array('root' =>$root));

    	$contents = $this->get('dev_theo_file_box.readfile')->read($path);
    


        

    	    	
        return $this->render('DevTheoFileBoxBundle:Default:index.html.twig', array( 'contents' => $contents));
    }


public function GetcontentAction($dir)
    {
        $path = $this->container->getParameter('root');
        if ($path['nom'].'/'.$dir != $path['nom'] ) 
        {
          $path = $path['nom'].'/'.$dir;
        }
        else
        {
            $path=$path['nom'];
        }
        
        var_dump($path);
        $root['nom'] = $path;
        $root['oldnom'] = dirname($path);
        var_dump($root);
        
        $this->get('dev_theo_file_box.params')->save(array('root' =>$root));

        if (filetype($path) == 'dir') 
        {
            $contents = $this->get('dev_theo_file_box.readfile')->read($path); 
           
            return $this->render('DevTheoFileBoxBundle:Default:getcontent.html.twig', array('contents' => $contents,'path'=>$path));
        }
        else
        {
            $contents = $this->get('dev_theo_file_box.readfile')->get_file_content($path,$dir);
            return $this->render('DevTheoFileBoxBundle:Default:modifyfile.html.twig', array('dir' => $dir , 'contents' => $contents));
        }
        
    }

    public function CreateDirAction($path,$name)
    {

        return $this->render('DevTheoFileBoxBundle:Default:index.html.twig', array('name' => $name, 'contents' => $contents, 'path' => $path));
    }

    public function GetBackAction()
    {
        $path = $this->container->getParameter('root');
        $root['nom'] = $path['oldnom'];
         if (dirname($path['oldnom']) != "." && dirname($path['oldnom']) != "..") {
            $root['oldnom'] = dirname($path['nom']);
         }
        $this->get('dev_theo_file_box.params')->save(array('root' =>$root));
        var_dump($root);
        $path = $path['oldnom'];
         if (filetype($path) == 'dir') 
        {
            $contents = $this->get('dev_theo_file_box.readfile')->read($path); 
           
            return $this->render('DevTheoFileBoxBundle:Default:getcontent.html.twig', array('contents' => $contents,'path'=>$path));
        }
        else
        {
            $contents = $this->get('dev_theo_file_box.readfile')->get_file_content($path);
            return $this->render('DevTheoFileBoxBundle:Default:modifyfile.html.twig', array('dir' => $dir , 'contents' => $contents));
        }

    }


}
