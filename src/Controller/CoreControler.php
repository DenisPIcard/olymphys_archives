<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Entity\TblFichiers;
use App\Entity\TblPaths;
use App\Entity\User\User;
use App\Form\UploadFichierType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AllowDynamicProperties] class CoreControler extends AbstractController
{
    private EntityManagerInterface $doctrine;

    public function __construct(EntityManagerInterface $doctrine, ManagerRegistry $managerRegistry){
            $this->doctrine=$doctrine;

            $this->archivesManager=$managerRegistry->getManager('archives');
    }
    #[Route('/', name: 'accueil')]

    public function index(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine2): Response
    {
        //pour inialiser un super_admin et le path racine
        /*$user=new User();
        $user->setUsername('jouve');
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setPassword($passwordHasher->hashPassword($user,'12345678'));
        $this->doctrine->persist($user);
        $this->doctrine->flush();

        $path=new TblPaths();
        $path->setRang(0);
        $path->setName('archives OdPF');
        $this->archivesManager->persist($path);
        $this->archivesManager->flush();*/




        $path0=$this->archivesManager->getRepository(TblPaths::class)->findOneBy(['rang'=>0]);
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        return $this->redirectToRoute('archives',['idPath'=>$path0->getId()]);

    }
    #[Route('/archives,{idPath}', name: 'archives')]
    #[isGranted('ROLE_COMITE')]
    public function archives(Request $request,$idPath=null): Response
    {
        if($idPath==null){
            $path=$this->archivesManager->getRepository(TblPaths::class)->findOneBy(['name'=>'uploads']);//a la sortie de l'identification, où retour vers l'accueil
        }
        else {
            $path = $this->archivesManager->getRepository(TblPaths::class)->find($idPath);

        }
        $fichiers=$path->getTblFichiers();

        $directories = $path->getSubFolders();

        $pathString=$this->doctrine->getRepository(TblFichiers::class)->getPathString($path);
        $breadcum_=$path;
        $breadcum=[];
        for($i=0;$i<=$path->getRang();$i++){
            $breadcum[$i]=$breadcum_;
            $breadcum_= $breadcum_->getDirectory();
        }

        $sousDirectories=$this->doctrine->getRepository(TblPaths::class)->createQueryBuilder('d');
           

        return $this->render('core/explorer.html.twig', ['fichiers'=>$fichiers,'path_'=>$path,
            'pathStr'=>$pathString,'directories'=>$directories, 'breadcum'=>$breadcum, 'sousDirectories'=>$sousDirectories]);
    }

    #[Route('/choix', name: 'choix')]
    #[isGranted('ROLE_COMITE')]
    public function choix(Request $request): Response
    {
        dd($request);
    }
    #[Route('/telecharger,{idPath}', name: 'telecharger')]
    #[isGranted('ROLE_COMITE')]
    public function telecharger(Request $request,$idPath,SluggerInterface $slugger): Response
    {

        $path=$this->archivesManager->getRepository(TblPaths::class)->find($idPath);
        $listeFichiers=$path->getTblFichiers();
        $fichiersRepo=$this->archivesManager->getRepository(TblFichiers::class);
        $form=$this->createForm(UploadFichierType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()){
            $fichierFiles = $form->get('fichier')->getData();
            foreach($fichierFiles as $fichierFile) {
                if ($fichierFile !== null) {
                    $fichier=new TblFichiers();
                    $fichier->setPath($path);
                    $originalFilename = pathinfo($fichierFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '.' . $fichierFile->guessExtension();
                    $i = 1;
                    if ($listeFichiers !== null) {
                        foreach ($listeFichiers as $afichier) {
                            if ($afichier->getName() == $newFilename) {
                                $newFilename = $safeFilename . '(' . $i . ')' . '.' . $fichierFile->guessExtension();
                                $i++;
                            }
                        }
                    }
                    $fichier->setName($newFilename);
                    $fichier->setCreatedAt(new DateTimeImmutable('now'));
                    $fichier->setCreator($this->getUser()->getPrenomNom());
                    $fichier->setSize($fichierFile->getSize());
                    try {
                        $fichierFile->move(
                            $fichiersRepo->getPathString($path),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
                    $this->archivesManager->persist($fichier);
                    $this->archivesManager->flush();
                    $path->addTblFichier($fichier);
                }
            }
            return $this->redirectToRoute('archives',['idPath'=>$path->getId()]);
        }

        return  $this->render('core/telechargerFichier.html.twig',['form'=>$form->createView()]);
    }
    #[Route('/newfolder,{idPath}', name: 'newfolder')]
    #[isGranted('ROLE_COMITE')]
    public function newfolder(Request $request, $idPath)
    {
        $path=$this->archivesManager->getRepository(TblPaths::class)->find($idPath);
        $rang=$path->getRang();
        $newPath=new TblPaths();
        $newPath->setName($request->query->get('nomFolder'));
        $newPath->setRang($rang+1);
        $newPath->setDirectory($path);
        $newPath->setCreatedAt(new DateTimeImmutable('now'));
        $newPath->setCreator($this->getUser());
        $this->archivesManager->persist(($newPath));
        $this->archivesManager->flush();
        return $this->redirectToRoute('archives',['idPath'=>$path->getId()]);

    }
}
