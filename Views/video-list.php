<?php   

$this->layout('layout'); ?>

                <ul class="videos__container" method="get">
                    <?php foreach($videoList as $video): ?>
                            <li class="videos__item">
                                <?php if ($video->getFilePath() !== null): ?>
                                    <a href="<?= $video->url;?>">
                                        <img width="100%" height="72%" src="/img/uploads/<?= $video->getFilePath(); ?>" alt=""/>
                                </a>
                                    <?php else: ?>
                                <iframe width="100%" height="72%" src="<?php echo $video->url; ?>"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                                    <?php endif; ?>
                                <div class="descricao-video">
                                    <img src="./img/logo.png" alt="logo canal alura">
                                    <h3><?php echo $video->titulo; ?></h3>
                                    <div class="acoes-video">
                                        <a href="editar-video?id=<?php echo $video->id;?>">Editar</a>
                                        <a href="remover-video?id=<?php echo $video->id;?>">Excluir</a>
                                        <a href="deletar-capa?id=<?php echo $video->id; ?>" class="btn-deletar-capa">Deletar capa</a>
                                    </div>
                                </div>
                            </li>
                    <?php endforeach;?>
                </ul>
            </body>
            </html>