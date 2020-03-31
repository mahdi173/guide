<?php


namespace App\Controller;


use App\DTO\GraphicDataDTO;
use App\Form\GraphicDataType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/graphic_data", name="graphic_data")
     */
    public function graphic_data(Request $request)
    {
       $edit=$request->query->get('edit');
        $graphicData=new GraphicDataDTO();
        $form=$this->createForm(GraphicDataType::class,$graphicData);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
//            dd($form->getData());
            $type=$form->get('type')->getData();
            $graphicTitle=$form->get('graphicTitle')->getData();
            $titleX=$form->get('titleX')->getData();
            $titleY=$form->get('titleY')->getData();
            $color=$form->get('color')->getData();
            $dataX=$form->get('dataX')->getData();
            $showValues=$form->get('showValues')->getData();
            $showGrid=$form->get('showGrid')->getData();
            $axeX=explode("\r\n",$dataX);

            $dataY=$form->get('dataY')->getData();
            $axeY=explode("\r\n",$dataY);

            return $this->render(
                'graphics/graphics_generator.html.twig', [
                    'type'=>$type,
                    'graphicTitle'=>$graphicTitle,
                    'titleX'=>$titleX,
                    'titleY'=>$titleY,
                    'axeX'=>$axeX,
                    'axeY'=>$axeY,
                    'color'=>$color,
                    'showValues'=>$showValues,
                    'showGrid'=>$showGrid,


            ]);
        }


        return $this->render(
            'graphics/graphics_data.html.twig', [
              'form'=>$form->createView(),
                'edit'=>$edit,
            ]
        );
    }


}
