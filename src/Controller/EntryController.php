<?php

namespace App\Controller;

use App\Entity\Entry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EntryController extends AbstractController
{
    #[Route('/entry/new', name: 'entry_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ValidatorInterface $validator): Response
    {
        $entry = new Entry();

        if ($request->isMethod('POST')) {
            $entry->name = $request->request->get('name');
            $entry->birthday = $request->request->get('birthday');
            $entry->score = $request->request->get('score');
            $entry->customField = $request->request->get('customField');

            $errors = $validator->validate($entry);

            if (count($errors) > 0) {
                return $this->render('entry/form.html.twig', [
                    'entry' => $entry,
                    'errors' => $errors
                ]);
            }

            return new Response('<h2>Validation passed</h2>');
        }

        return $this->render('entry/form.html.twig', [
            'entry' => $entry,
            'errors' => []
        ]);
    }


    #[Route('/entry/new/xml', name: 'entry_new_xml', methods: ['GET', 'POST'])]
    public function newXML(Request $request, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {
        $entry = new Entry();

        if ($request->isMethod('POST')) {
            $xmlData = $request->request->get('xml');

            try {
                $entry = $serializer->deserialize($xmlData, Entry::class, 'xml');
            } catch (\Exception $e) {
                return new Response('<h2>Invalid XML: ' . $e->getMessage() . '</h2>');
            }

            $errors = $validator->validate($entry);

            if (count($errors) > 0) {
                return $this->render('entry/form.html.twig', [
                    'entry' => $entry,
                    'errors' => $errors
                ]);
            }

            return new Response('<h2>Validation passed</h2>');
        }

        return $this->render('entry/form.html.twig', [
            'entry' => $entry,
            'errors' => []
        ]);
    }

}
