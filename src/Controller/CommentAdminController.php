<?php

namespace App\Controller;

use App\Repository\CommentRepository;

use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CommentAdminController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class CommentAdminController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="comment_admin")
     */
    public function index(CommentRepository $commentRepository, Request $request,PaginatorInterface $paginator)
    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $q = $request->query->get('q');

//        if (empty($q)) {
//            $queryBilder = $commentRepository->createQueryBuilder('c')->orderBy('c.createdAt','DESC');
//        } else {
//            $queryBilder = $commentRepository->getWithSearchQueryBuilder($q);
//
//        }
        $queryBilder = $commentRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate($queryBilder,$request->query->getInt('page',1),$request->query->getInt('limit',10));

        return $this->render('comment_admin/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
