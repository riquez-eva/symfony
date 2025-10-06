<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class MailController extends AbstractController
{
    #[Route('/mail', name: 'app_mail')]
    public function sendMail(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $data = $form->getData();
            //dd($data);

            $email = (new TemplatedEmail())
            ->from($data['email'])
            ->to('admin@site.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($data['sujet'])
            ->htmlTemplate('mail/message.html.twig')
            ->context([
                'message' => $data['message'],
            ]);
            //->text('Sending emails is fun again!')
            //->html($data['message']);
            
            $mailer->send($email);

            $this->addFlash('notice', 'Votre message est dans la boite !!!' );

            $this->redirect('/accueil');
        }

        return $this->render('mail/index.html.twig', [
            'form' => $form,
        ]);
    }
}
