<div class="d-flex justify-content-center">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php 
            $paginaAtual = $this->uri->segment(1) ? $this->uri->segment(1) : 1 ;

            $controle = 1 ;

            for($i = 1; $i <= ceil($qtdPaginas / 5); $i++){
                if($paginaAtual > $i * 5) { 
                    $controle += 5; 
                } 
                if($paginaAtual <= ($i * 5) + 5){
                    break;
                }
            }

            for($cont = $controle; $cont <= $qtdPaginas; $cont++) {
                if($cont == $controle && $paginaAtual != 1 ) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= site_url($paginaAtual-1)?>">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; 
                     if ($cont == $controle && $controle > 5) :?>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">
                            <span aria-hidden="true">...</span>
                        </a>
                    </li>
                <?php endif; ?> 
                <li class="page-item <?= $cont == $paginaAtual ? 'disabled' : '' ;?> ">
                    <a class="page-link" href="<?= site_url($cont) ?>"><?= $cont ?></a>
                </li>
                <?php if ($cont != $qtdPaginas && $cont == $controle + 4) : ?>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">
                            <span aria-hidden="true">...</span>
                        </a>
                    </li>
                <?php endif; ?> 
            <?php if($cont == $controle + 4 && $paginaAtual != $qtdPaginas) : ?>
                <li class="page-item">
                    <a class="page-link" href="<?= site_url($paginaAtual+1)?>">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php 
                    break;
                endif;
            } ?>
        </ul>
    </nav>
</div>