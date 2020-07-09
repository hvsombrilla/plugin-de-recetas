<?php

/**
 *
 */
class RecetaClass
{

    public function __construct()
    {

    }

    public function save()
    {
        global $wpdb;
        header('Content-Type: application/json');

        $doctor = get_current_user_ID();

        $data = [
            'comentario' => $_POST['comments'],
            'time'       => time(),
            'doctor'     => $doctor,
            'paciente' => $_POST['paciente']
        ];

        $wpdb->insert($wpdb->prefix . 'recetas', $data);

        $receta = $wpdb->insert_id;

        foreach ($_POST['items'] as $item) {
            $data = ['rid' => $receta, 'pid' => $item['pid'], 'dosis' => $item['dosis'], 'duracion' => $item['duracion'], 'dosis_full' => $item['dosis_full']];
            $wpdb->insert($wpdb->prefix . 'recetas_items', $data);
        }

        foreach ($_POST['prescriptions'] as $item) {
            $data = ['rid' => $receta, 'title' => $item['title'] ];
            $wpdb->insert($wpdb->prefix . 'recetas_prescriptions', $data);
        }

        foreach ($_POST['protocolos'] as $protocolo) {
            $data = ['rid' => $receta, 'pid' => $protocolo ];
            $wpdb->insert($wpdb->prefix . 'recetas_protocolos', $data);
        }


        echo json_encode(['rid' => $receta]);
        exit();
    }

    public function getProducts()
    {

        $search = (empty($_GET['q'])) ? "" : $_GET['q'];

        $args = ['post_type' => 'productos'];

        if (!empty($_GET['s'])) {
            $args['s'] = $_GET['s'];
        } else {
            if (!empty($_GET['cat'])) {
                 $args['cat'] = $_GET['cat'];
            }
        }
        

       

        $posts = get_posts($args);

        $results = [];?>
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">

<?php

        $active = true;
        $cont   = 0;

        foreach ($posts as $p) {
            $cont++;
            if ($cont == 1) {
                echo "<div class='carousel-item ";
                echo ($active) ? "active" : "";
                echo "'><div class='row'>";
            }
            $active = false;

            $imagen = wp_get_attachment_image_src(get_post_meta($p->ID, 'imagen', true));
            ?>

            <div class="col-md-4">
                <div class="card">
                    <img src="<?php echo $imagen[0]; ?>" alt="">
<div class="p-2"><h2 class="product-title"><?php echo $p->post_title; ?></h2>

                    <input type="submit" class="btn btn-primary btn-block" value="Agregar" onclick="addToCart(<?php echo $p->ID; ?>)"></div>

                </div>
            </div>

            <?php

            if ($cont == 3) {
                echo "</div></div>";
                $cont = 0;
            }

        }

        ?>

 </div>

<!--
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a> -->
</div>

<?php exit();
    }

    public function getProduct($pid)
    {
        header('Content-Type: application/json');
        $post = get_post($pid);

        $result = [];
        $imagen = wp_get_attachment_image_src(get_post_meta($post->ID, 'imagen', true));

        $result = ['id' => $post->ID, 'title' => productName( $post->ID ), 'imagen' => $imagen[0]];

        echo json_encode($result);
        exit();
    }

    public function generatePDF($id)
    {
        ob_start();
        include RECETA_MEDICA_PATH . '/views/recetas/view-pdf.php';
        $content = ob_get_contents();
        ob_clean();

        $pdfdir = wp_upload_dir();
        $pdfdir = $pdfdir['basedir'] . '/recetas';

        if (!is_dir($pdfdir)) {
            mkdir($pdfdir);
        }

        $filepath = $pdfdir . '/' . sha1("Kin" . $id) . '.pdf';

        require_once RECETA_MEDICA_PATH . '/vendor/autoload.php';

        $mpdf = new \Mpdf\Mpdf();

// Write some HTML code:

        $mpdf->WriteHTML($content);

// Output a PDF file directly to the browser
        $mpdf->Output($filepath);
        return $filepath;
    }

}
