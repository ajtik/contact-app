<?php declare(strict_types = 1);

namespace CloverDX\Model\Service\Doctrine;

use CloverDX\Model\Entity\Contact;
use CloverDX\Model\Service\ContactManager as ContactManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class ContactManager implements ContactManagerInterface
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param Contact $contact
     * @return void
     */
    public function save(Contact $contact): void
    {
        $this->entityManager->persist($contact);
        $this->entityManager->flush();
    }

}
