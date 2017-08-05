<?php

namespace AppBundle\Controller;

use AppBundle\Entity\customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CustomerController extends Controller
{
    /**
     * @Route("/customers", name="customers_list")
     */
    public function listAction(Request $request)
    {
        $customers =$this->getDoctrine()
            ->getRepository('AppBundle:customer')
            ->findAll();

        return $this->render('customerlist/index.html.twig',array(
            'customers'=> $customers

            ));
    }

    /**
     * @Route("/customer/create", name="customer_create")
     */
    public function createAction(Request $request)
    {
        $customer = new Customer();

        $form = $this->createFormBuilder($customer)
            ->add('firstname', TextType::class, array('attr' =>array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('lastname', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=> 'margin-bottom:15px')))
            ->add('address', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=> 'margin-bottom:15px')))
            ->add('city', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=> 'margin-bottom:15px')))
            ->add('state', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=> 'margin-bottom:15px')))
            ->add('country', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=> 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label'=>'Create Account', 'attr'=>array('class'=>'btn btn-primary', 'style'=> 'margin-bottom:15px')))
            ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                //get data
                $firstname = $form['firstname']->getData();
                $lastname = $form['lastname']->getData();
                $address = $form['address']->getData();
                $city = $form['city']->getData();
                $state = $form['state']->getData();
                $country = $form['country']->getData();

                //set data
                $customer->setFirstname($firstname);
                $customer->setLastname($lastname);
                $customer->setAddress($address);
                $customer->setCity($city);
                $customer->setState($state);
                $customer->setCountry($country);

                $em = $this->getDoctrine()->getManager();

                $em->persist($customer);
                $em->flush();

                $this->addFlash(
                    'notice', 
                    'customer is success added'
                    );
                 return $this->redirectToRoute('customers_list');
            }

        return $this->render('customerlist/create.html.twig', array(
            'form'=>$form->createView()
            ));
    }

    /**
     * @Route("/customer/edit/{id}", name="customers_edit")
     */
    public function editAction($id, Request $request)
    {
        $customer = $this->getDoctrine()
            ->getRepository('AppBundle:customer')
            ->find($id);

            $customer->setFirstname($customer->getFirstname());
            $customer->setLastname($customer->getLastname());
            $customer->setAddress($customer->getAddress());
            $customer->setCity($customer->getCity());
            $customer->setState($customer->getState());
            $customer->setCountry($customer->getCountry());

               $form = $this->createFormBuilder($customer)
            ->add('firstname', TextType::class, array('attr' =>array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('lastname', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=> 'margin-bottom:15px')))
            ->add('address', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=> 'margin-bottom:15px')))
            ->add('city', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=> 'margin-bottom:15px')))
            ->add('state', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=> 'margin-bottom:15px')))
            ->add('country', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=> 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label'=>'Create Account', 'attr'=>array('class'=>'btn btn-primary', 'style'=> 'margin-bottom:15px')))
            ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                //get data
                $firstname = $form['firstname']->getData();
                $lastname = $form['lastname']->getData();
                $address = $form['address']->getData();
                $city = $form['city']->getData();
                $state = $form['state']->getData();
                $country = $form['country']->getData();

                $em = $this->getDoctrine()->getManager();
                $customer = $em->getRepository('AppBundle:customer')->find($id);
                //set data
                $customer->setFirstname($firstname);
                $customer->setLastname($lastname);
                $customer->setAddress($address);
                $customer->setCity($city);
                $customer->setState($state);
                $customer->setCountry($country);

                $em->flush();

                $this->addFlash(
                    'notice', 
                    'customer is success updated'
                    );
                 return $this->redirectToRoute('customers_list');
            }

        return $this->render('customerlist/edit.html.twig',array(
            'customer'=>$customer,
            'form'=>$form->createView()

            ));
        
    }

    /**
     * @Route("/customer/details/{id}", name="customers_details")
     */
    public function detailsAction($id)
    {
        $customer =$this->getDoctrine()
            ->getRepository('AppBundle:customer')
            ->find($id);

        return $this->render('customerlist/details.html.twig',array(
            'customer'=> $customer
            ));
    }

    /**
     * @Route("/customer/delete/{id}", name="customer_delete")
     */
    public function deleteAction($id){
        $em =$this->getDoctrine()->getManager();
        $customer = $em->getRepository('AppBundle:customer')->find($id);

            $em->remove($customer);
            $em->flush();

                $this->addflash(
                'notice',
                'Customer information Removed'
                );

             return $this->redirectToRoute('customers_list');

    }
}
