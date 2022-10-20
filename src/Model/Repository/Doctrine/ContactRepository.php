<?php declare(strict_types = 1);

namespace CloverDX\Model\Repository\Doctrine;

use CloverDX\Model\Entity\Contact;
use CloverDX\Model\Repository\ContactRepository as ContactRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class ContactRepository implements ContactRepositoryInterface
{

    /** @var ObjectRepository<Contact> */
    private ObjectRepository $repository;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        $this->repository = $this->entityManager->getRepository(Contact::class);
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

}
