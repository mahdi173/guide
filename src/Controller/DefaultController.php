<?php


namespace App\Controller;


use App\DTO\GraphicDataDTO;
use App\Form\GraphicDataType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $aa=[];
       $edit=$request->query->get('edit');
//       if($edit){
//           if($request->request->get('dataExtra')) {
//               $dataExtra = $request->request->get('dataExtra');
//               $aa=explode("\r\n",$dataExtra);
//               dd($aa);
//           }
//       }
        $graphicData=new GraphicDataDTO();
        $form=$this->createForm(GraphicDataType::class,$graphicData);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
//            dd($request->request->all());
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
            $titles=null;$dataExtra=null;$colors=null;$aa=[];
            $color1=null;$color2=null;$color3=null;
            /*extra yaxis*/
            if($request->request->get('title')){
                $titles=$request->request->get('title');
            }
            if($request->request->get('dataExtra')) {
                $dataExtra = $request->request->get('dataExtra');


            }
            if($request->request->get('color')) {
                $colors = $request->request->get('color');
            }


            if($colors){
                $color1=$colors[0];
                if(count($colors)>=2){
                    $color2=$colors[1];
                }
                if(count($colors)==3){
                    $color3=$colors[2];
                }
            }

            $hasMultipleY=false;
            $ax1=[];$ax2=[];$ax3=0;

            if($titles && $dataExtra && $colors && count($titles)!=0 && count($dataExtra)!=0 && count($colors)!=0){
                $hasMultipleY=true;


                    $ax1 = explode("\r\n", $dataExtra[0]);
                if(count($dataExtra)>=2 ) {
                    $ax2 = explode("\r\n", $dataExtra[1]);
                }
                if(count($dataExtra)==3 ) {
                    $ax3 = explode("\r\n", $dataExtra[2]);
                }

                }






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
                    'hasMultipleY'=>$hasMultipleY,
                    'titles'=>$titles,
                    'axe1'=>$ax1,
                    'axe2'=>$ax2,
                    'axe3'=>$ax3,
                    'dataExtra'=>$dataExtra,
                    'aa'=>$aa,
                    'colors'=>$colors,
                    'color1'=>$color1,
                    'color2'=>$color2,
                    'color3'=>$color3,


            ]);
        }


        return $this->render(
            'graphics/graphics_data.html.twig', [
              'form'=>$form->createView(),
                'aa'=>$aa,
                'edit'=>$edit,
            ]
        );
    }

    /**
     * @Route("/add-new-data", name="add_new_data")
     */
    public function add_new_data(Request $request)
    {

        $html =  $this->renderView("graphics/graphics_extra_data.html.twig");


        return new JsonResponse([
            "ok"=>true,
            "html"=>$html,
            "request"=>$request->request->get("dummy"),
        ]);
    }

    /**
     * @Route("/calcul_data", name="calcul_data")
     */
    public function calcul_data(Request $request)
    {
dump($request);
        $html =  $this->renderView("graphics/graphics_extra_data.html.twig");


        return new JsonResponse([
            "ok"=>true,
            "html"=>$html,
            "request"=>$request->request->get("dummy"),
        ]);
    }
}
