<?php declare(strict_types = 1);

namespace CloverDX\Controller;

use CloverDX\Form\ContactFormType;
use CloverDX\Model\Entity\Contact;
use CloverDX\Model\Repository\ContactRepository;
use CloverDX\Model\Service\ContactManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact')]
class ContactController extends AbstractController
{

    public function __construct(
        private readonly ContactRepository $contactRepository,
        private readonly ContactManager $contactManager,
    )
    {
    }

    #[Route('/', name: 'contact_index')]
    public function index(Request $request): Response
    {
        $contact = new Contact();

        $contactForm = $this->createForm(ContactFormType::class, $contact);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() === true && $contactForm->isValid() === true) {
            /** @var Contact $contact */
            $contact = $contactForm->getData();
            $this->contactManager->save($contact);

            return $this->redirectToRoute('contact_index');
        }

        return $this->render('controller/contact/index.html.twig', [
            'contacts' => $this->contactRepository->findAll(),
            'contactForm' => $contactForm->createView(),
        ]);
    }

}
