<?php declare(strict_types = 1);

namespace CloverDX\Model\Service;

use CloverDX\Model\Entity\Contact;

interface ContactManager
{

    public function save(Contact $contact): void;

}
