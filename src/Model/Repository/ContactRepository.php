<?php declare(strict_types = 1);

namespace CloverDX\Model\Repository;

use CloverDX\Model\Entity\Contact;

interface ContactRepository
{

    /** @return Contact[] */
    public function findAll(): array;

}
