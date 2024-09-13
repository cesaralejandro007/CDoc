<?php
use config\componentes\configSistema as configSistema;
?>
  <aside class="sidebar">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="/" class="logo-wrapper" title="Home">
                <span class="sr-only">Home</span>
                <span class="icon logo" aria-hidden="true"></span>
                <div class="logo-text">
                    <span class="logo-title">CDoc</span>
                </div>

            </a>
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle" aria-hidden="true"></span>
            </button>
        </div>
        <div class="sidebar-body">
            <ul class="sidebar-body-menu">
                <li>
                    <a href="?pagina=<?php configSistema::_PRINCIPAL_();?>"><span class="icon home" aria-hidden="true"></span>Principal</a>
                </li>
                <?php if($_SESSION["usuario"]["rol"] == 'Administrador'){ ?>
                <li>
                    <a href="?pagina=<?php configSistema::_ConsultarUsuario_();?>"><span class="icon document" aria-hidden="true"></span>Usuarios</a>
                </li>
                <li>
                    <a href="?pagina=<?php configSistema::_ConsultarSecciones_();?>"><span class="icon document" aria-hidden="true"></span>Secciones</a>
                </li>
                <li>
                    <a href="?pagina=<?php configSistema::_Historial_();?>"><span class="icon document" aria-hidden="true"></span>Historial</a>
                </li>
                <li>
                    <a href="?pagina=<?php configSistema::_BitacoraSistema_();?>"><span class="icon document" aria-hidden="true"></span>Bitacora del Sistema</a>
                </li>
                <?php  } ?>
            </ul>
            <span class="system-menu__title">documentos</span>
            <ul class="sidebar-body-menu">
            <li>
                    <a class="show-cat-btn" href="##">
                        <span class="icon folder" aria-hidden="true"></span>Gestionar Doc.
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a href="?pagina=<?php configSistema::_DocumentosEntrada_();?>"><span class="icon document" aria-hidden="true"></span>Entrada</a>
                        </li>
                        <li>
                            <a href="?pagina=<?php configSistema::_DocumentosSalida_();?>"><span class="icon document" aria-hidden="true"></span>Salida</a>
                        </li>
                        <li>
                            <a href="?pagina=<?php configSistema::_DocumentosSinEntrada_();?>"><span class="icon document" aria-hidden="true"></span>Sin Entrada</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar-footer">
        <hr>
        <a href="##" class="sidebar-user">
            <span class="sidebar-user-img">
                <picture><source srcset="assets/img/avatar/avatar-illustrated-02.webp" type="image/webp"><img src="assets/img/avatar/avatar-illustrated-02.png" alt="User name"></picture>
            </span>
            <div class="sidebar-user-info">
                <span class="sidebar-user__title">Ing. Cesar Vides.</span>
                <span class="sidebar-user__subtitle">Gerente de Soporte</span>
            </div>
        </a>
        <hr>
        <a href="##" class="sidebar-user">
            <span class="sidebar-user-img">
                <picture><source srcset="assets/img/avatar/avatar-illustrated-01.webp" type="image/webp"><img src="assets/img/avatar/avatar-illustrated-01.png" alt="User name"></picture>
            </span>
            <div class="sidebar-user-info">
                <span class="sidebar-user__title">Ing. Maria Zapata.</span>
                <span class="sidebar-user__subtitle">Gerente de Soporte</span>
            </div>
        </a>
        <hr>
    </div>
</aside>