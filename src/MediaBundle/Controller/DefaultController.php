<?php

namespace MediaBundle\Controller;

use MediaBundle\Entity\Album;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use MediaBundle\Entity\Commentaire;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('MediaBundle:Default:index.html.twig');
    }

    /**
     * @Route("/{id}/comment/new", name="comment_new")
     * @Method({"GET", "POST"})
     */
    public function newCommentAction(Request $request, $id)
    {
        $commentaire = new Commentaire();

        $form = $this->createForm('MediaBundle\Form\CommentaireType',$commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $commentaire = $form->getData();

            if(empty($commentaire->getUtilisateur()) ){
                $commentaire->setUtilisateur('Anonyme');
            }
            $commentaire->setAlbum($id);
            /*$toto = new Album();
            $toto->addCommentaire($id);
            $commentaire->setAlbum($id);*/
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('_show', array('id' =>$id));
        }

        return $this->render('MediaBundle::comment.html.twig', array(
            'id'=>$id,
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/comment/{id}/delete/",name="comment_delete")
     */
    public function deleteAction (Commentaire $commentaire, $id)
    {

        $commentaire = $this->getDoctrine()
            ->getRepository('MediaBundle:Commentaire')
            ->findOneById($id);
//        $actuality = $this->getDoctrine()
//            ->getRepository('DojoBundle:Actuality')
//            ->findOneById($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($commentaire);
        $em->flush();

        return $this->redirectToRoute('_index');

    }

}
