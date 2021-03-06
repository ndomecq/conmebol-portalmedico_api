<?php
    $app->post('/v1/login', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['usuario_var01'];
        $val02      = $request->getParsedBody()['usuario_var02'];
        $val03      = $request->getParsedBody()['usuario_var03'];
        $val04      = $request->getParsedBody()['usuario_var04'];
        $val05      = $request->getParsedBody()['usuario_var05'];
        $val06      = $request->getParsedBody()['usuario_var06'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06)) {
            $sql00  = "SELECT
            a.PERFICCOD                         AS          persona_codigo,
            a.PERFICNOM                         AS          persona_nombre,
            a.PERFICUSE                         AS          persona_user,
            a.PERFICCON                         AS          persona_contrasenha,
            a.PERFICPAT                         AS          persona_path,
            a.PERFICMAI                         AS          persona_email,
            a.PERFICTEF                         AS          persona_telefono,
            a.PERFICOBS                         AS          persona_observacion,
            a.PERFICAUS                         AS          persona_usuario,
            a.PERFICAFH                         AS          persona_fecha_hora,
            a.PERFICAIP                         AS          persona_ip,

            b.DOMFICCOD                         AS          tipo_estado_codigo,
            b.DOMFICNOI                         AS          tipo_estado_nombre_ingles,
            b.DOMFICNOC                         AS          tipo_estado_nombre_castellano,
            b.DOMFICNOP                         AS          tipo_estado_nombre_portugues,

            c.DOMFICCOD                         AS          tipo_acceso_codigo,
            c.DOMFICNOI                         AS          tipo_acceso_nombre_ingles,
            c.DOMFICNOC                         AS          tipo_acceso_nombre_castellano,
            c.DOMFICNOP                         AS          tipo_acceso_nombre_portugues,

            d.DOMFICCOD                         AS          tipo_perfil_codigo,
            d.DOMFICNOI                         AS          tipo_perfil_nombre_ingles,
            d.DOMFICNOC                         AS          tipo_perfil_nombre_castellano,
            d.DOMFICNOP                         AS          tipo_perfil_nombre_portugues,

            e.teamFifaId                        AS          equipo_codigo,
            e.internationalName                 AS          equipo_nombre,

            f.DOMFICCOD                         AS          tipo_categoria_codigo,
            f.DOMFICNOI                         AS          tipo_categoria_nombre_ingles,
            f.DOMFICNOC                         AS          tipo_categoria_nombre_castellano,
            f.DOMFICNOP                         AS          tipo_categoria_nombre_portugues
            
            FROM [adm].[PERFIC] a
            INNER JOIN [adm].[DOMFIC] b ON a.PERFICEST = b.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] c ON a.PERFICTIP = c.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] d ON a.PERFICROL = d.DOMFICCOD
            INNER JOIN [comet].[teams] e ON a.PERFICEQU = e.teamFifaId
            INNER JOIN [adm].[DOMFIC] f ON a.PERFICCAT = f.DOMFICCOD

            WHERE a.PERFICMAI = ?
            
            ORDER BY a.PERFICNOM";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]);
                
                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $pass = trim($rowMSSQL['persona_contrasenha']);

                    if (password_verify($val02, $pass)) {
                        if ($rowMSSQL['equipo_codigo'] == 1) {
                            $equipo_codigo  = 39393;
                            $equipo_nombre  = 'CONFEDERACIÓN SUDAMERICANA DE FÚTBOL';
                        } else {
                            $equipo_codigo  = $rowMSSQL['equipo_codigo'];
                            $equipo_nombre  = trim($rowMSSQL['equipo_nombre']);
                        }

                        $persona_fecha_hora = date_format(date_create($rowMSSQL['persona_fecha_hora']), 'd/m/Y H:i:s');
                    
                        if (isset($rowMSSQL['persona_path'])){
                            $persona_path = $rowMSSQL['persona_path'];
                        } else {
                            $persona_path = 'assets/images/users/defaul.png';
                        }

                        $detalle    = array(
                            'persona_codigo'                        => $rowMSSQL['persona_codigo'],
                            'persona_nombre'                        => trim($rowMSSQL['persona_nombre']),
                            'persona_user'                          => trim($rowMSSQL['persona_user']),
                            'persona_contrasenha'                   => trim($rowMSSQL['persona_contrasenha']),
                            'persona_path'                          => $persona_path,
                            'persona_email'                         => trim($rowMSSQL['persona_email']),
                            'persona_telefono'                      => trim($rowMSSQL['persona_telefono']),
                            'persona_observacion'                   => trim($rowMSSQL['persona_observacion']),
                            'persona_usuario'                       => trim($rowMSSQL['persona_usuario']),
                            'persona_fecha_hora'                    => $persona_fecha_hora,
                            'persona_ip'                            => trim($rowMSSQL['persona_ip']),

                            'tipo_estado_codigo'                    => $rowMSSQL['tipo_estado_codigo'],
                            'tipo_estado_nombre_ingles'             => trim($rowMSSQL['tipo_estado_nombre_ingles']),
                            'tipo_estado_nombre_castellano'         => trim($rowMSSQL['tipo_estado_nombre_castellano']),
                            'tipo_estado_nombre_portugues'          => trim($rowMSSQL['tipo_estado_nombre_portugues']),

                            'tipo_acceso_codigo'                    => $rowMSSQL['tipo_acceso_codigo'],
                            'tipo_acceso_nombre_ingles'             => trim($rowMSSQL['tipo_acceso_nombre_ingles']),
                            'tipo_acceso_nombre_castellano'         => trim($rowMSSQL['tipo_acceso_nombre_castellano']),
                            'tipo_acceso_nombre_portugues'          => trim($rowMSSQL['tipo_acceso_nombre_portugues']),

                            'tipo_perfil_codigo'                    => $rowMSSQL['tipo_perfil_codigo'],
                            'tipo_perfil_nombre_ingles'             => trim($rowMSSQL['tipo_perfil_nombre_ingles']),
                            'tipo_perfil_nombre_castellano'         => trim($rowMSSQL['tipo_perfil_nombre_castellano']),
                            'tipo_perfil_nombre_portugues'          => trim($rowMSSQL['tipo_perfil_nombre_portugues']),

                            'equipo_codigo'                         => $equipo_codigo,
                            'equipo_nombre'                         => $equipo_nombre,

                            'tipo_categoria_codigo'                 => $rowMSSQL['tipo_categoria_codigo'],
                            'tipo_categoria_nombre_ingles'          => trim($rowMSSQL['tipo_categoria_nombre_ingles']),
                            'tipo_categoria_nombre_castellano'      => trim($rowMSSQL['tipo_categoria_nombre_castellano']),
                            'tipo_categoria_nombre_portugues'       => trim($rowMSSQL['tipo_categoria_nombre_portugues'])
                        );

                        $result[]   = $detalle;

                        header("Content-Type: application/json; charset=utf-8");
                        $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                    } else {
                        $detalle    = array(
                            'persona_codigo'                        => '',
                            'persona_nombre'                        => '',
                            'persona_user'                          => '',
                            'persona_contrasenha'                   => '',
                            'persona_path'                          => '',
                            'persona_email'                         => '',
                            'persona_telefono'                      => '',
                            'persona_observacion'                   => '',
                            'persona_usuario'                       => '',
                            'persona_fecha_hora'                    => '',
                            'persona_ip'                            => '',

                            'tipo_estado_codigo'                    => '',
                            'tipo_estado_nombre_ingles'             => '',
                            'tipo_estado_nombre_castellano'         => '',
                            'tipo_estado_nombre_portugues'          => '',

                            'tipo_acceso_codigo'                    => '',
                            'tipo_acceso_nombre_ingles'             => '',
                            'tipo_acceso_nombre_castellano'         => '',
                            'tipo_acceso_nombre_portugues'          => '',

                            'tipo_perfil_codigo'                    => '',
                            'tipo_perfil_nombre_ingles'             => '',
                            'tipo_perfil_nombre_castellano'         => '',
                            'tipo_perfil_nombre_portugues'          => '',

                            'equipo_codigo'                         => '',
                            'equipo_nombre'                         => '',

                            'tipo_categoria_codigo'                 => '',
                            'tipo_categoria_nombre_ingles'          => '',
                            'tipo_categoria_nombre_castellano'      => '',
                            'tipo_categoria_nombre_portugues'       => ''
                        );

                        header("Content-Type: application/json; charset=utf-8");
                        $json = json_encode(array('code' => 401, 'status' => 'failure', 'message' => 'Contraseña invalida, vuelve a intentar', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                    }
                }

                if (!isset($result)){
                    $detalle    = array(
                        'persona_codigo'                        => '',
                        'persona_nombre'                        => '',
                        'persona_user'                          => '',
                        'persona_contrasenha'                   => '',
                        'persona_path'                          => '',
                        'persona_email'                         => '',
                        'persona_telefono'                      => '',
                        'persona_observacion'                   => '',
                        'persona_usuario'                       => '',
                        'persona_fecha_hora'                    => '',
                        'persona_ip'                            => '',

                        'tipo_estado_codigo'                    => '',
                        'tipo_estado_nombre_ingles'             => '',
                        'tipo_estado_nombre_castellano'         => '',
                        'tipo_estado_nombre_portugues'          => '',

                        'tipo_acceso_codigo'                    => '',
                        'tipo_acceso_nombre_ingles'             => '',
                        'tipo_acceso_nombre_castellano'         => '',
                        'tipo_acceso_nombre_portugues'          => '',

                        'tipo_perfil_codigo'                    => '',
                        'tipo_perfil_nombre_ingles'             => '',
                        'tipo_perfil_nombre_castellano'         => '',
                        'tipo_perfil_nombre_portugues'          => '',

                        'equipo_codigo'                         => '',
                        'equipo_nombre'                         => '',

                        'tipo_categoria_codigo'                 => '',
                        'tipo_categoria_nombre_ingles'          => '',
                        'tipo_categoria_nombre_castellano'      => '',
                        'tipo_categoria_nombre_portugues'       => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'ERROR: Verifique el usuario', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v1/000', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_orden'];
        $val03      = $request->getParsedBody()['tipo_nombre_ingles'];
        $val04      = $request->getParsedBody()['tipo_nombre_castellano'];
        $val05      = $request->getParsedBody()['tipo_nombre_portugues'];
        $val06      = $request->getParsedBody()['tipo_path'];
        $val07      = $request->getParsedBody()['tipo_dominio'];
        $val08      = $request->getParsedBody()['tipo_observacion'];
        $val09      = $request->getParsedBody()['tipo_usuario'];
        $val10      = $request->getParsedBody()['tipo_fecha_hora'];
        $val11      = $request->getParsedBody()['tipo_ip'];

        if (isset($val01) && isset($val03) && isset($val04) && isset($val05) && isset($val07) && isset($val09) && isset($val10) && isset($val11)) {
            $sql00  = "INSERT INTO [adm].[DOMFIC] (DOMFICEST, DOMFICORD, DOMFICNOI, DOMFICNOC, DOMFICNOP, DOMFICPAT, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val11]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $connMSSQL->lastInsertId()), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v1/100', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_sub_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_codigo'];
        $val03      = $request->getParsedBody()['tipo_sub_orden'];
        $val04      = $request->getParsedBody()['tipo_sub_nombre_ingles'];
        $val05      = $request->getParsedBody()['tipo_sub_nombre_castellano'];
        $val06      = $request->getParsedBody()['tipo_sub_nombre_portugues'];
        $val07      = $request->getParsedBody()['tipo_sub_path'];
        $val08      = $request->getParsedBody()['tipo_sub_dominio'];
        $val09      = $request->getParsedBody()['tipo_sub_observacion'];
        $val10      = $request->getParsedBody()['tipo_sub_usuario'];
        $val11      = $request->getParsedBody()['tipo_sub_fecha_hora'];
        $val12      = $request->getParsedBody()['tipo_sub_ip'];

        if (isset($val01) && isset($val02) && isset($val04) && isset($val05) && isset($val06) && isset($val08) && isset($val10) && isset($val11) && isset($val12)) {
            $sql00  = "INSERT INTO [adm].[DOMSUB] (DOMSUBEST, DOMSUBTIC, DOMSUBORD, DOMSUBNOI, DOMSUBNOC, DOMSUBNOP, DOMSUBPAT, DOMSUBVAL, DOMSUBOBS, DOMSUBAUS, DOMSUBAFH, DOMSUBAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val12]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $connMSSQL->lastInsertId()), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v1/400', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_acceso_codigo'];
        $val03      = $request->getParsedBody()['tipo_perfil_codigo'];
        $val04      = $request->getParsedBody()['equipo_codigo'];
        $val05      = $request->getParsedBody()['tipo_categoria_codigo'];
        $val06      = $request->getParsedBody()['persona_nombre'];
        $val07      = $request->getParsedBody()['persona_user'];
        $val08      = password_hash($request->getParsedBody()['persona_contrasenha'], PASSWORD_DEFAULT);
        $val09      = $request->getParsedBody()['persona_path'];
        $val10      = $request->getParsedBody()['persona_email'];
        $val11      = $request->getParsedBody()['persona_telefono'];
        $val12      = $request->getParsedBody()['persona_observacion'];
        $val13      = $request->getParsedBody()['persona_usuario'];
        $val14      = $request->getParsedBody()['persona_fecha_hora'];
        $val15      = $request->getParsedBody()['persona_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07) && isset($val08) && isset($val10) && isset($val13) && isset($val14) && isset($val15)) {
            $sql00  = "INSERT INTO [adm].[PERFIC] (PERFICEST, PERFICTIP, PERFICROL, PERFICEQU, PERFICCAT, PERFICNOM, PERFICUSE, PERFICCON, PERFICPAT, PERFICMAI, PERFICTEF, PERFICOBS, PERFICAUS, PERFICAFH, PERFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $val12, $val13, $val15]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $connMSSQL->lastInsertId()), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v1/401', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getParsedBody()['competicion_codigo'];
        $val02      = $request->getParsedBody()['persona_codigo'];
        $val03      = $request->getParsedBody()['competicion_persona_observacion'];
        
        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($aud01) && isset($aud02) && isset($aud03)) {
            $sql00  = "INSERT INTO [adm].[PERCOM] (PERCOMCOC, PERCOMPEC, PERCOMOBS, PERCOMAUS, PERCOMAFH, PERCOMAIP) VALUES (?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $aud01, $aud03]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: Ya se encuentra asiganda dicha competencia al medico. Verifique!'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v1/600', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['competencia_codigo'];
        $val03      = $request->getParsedBody()['juego_codigo'];
        $val04      = $request->getParsedBody()['equipo_codigo'];
        $val05      = $request->getParsedBody()['jugador_codigo'];
        $val06      = $request->getParsedBody()['lesion_fecha_hora'];

        $val07      = $request->getParsedBody()['tipo_clima_codigo'];
        $val08      = $request->getParsedBody()['temperatura_numero'];
        $val09      = $request->getParsedBody()['tipo_distancia_codigo'];
        $val10      = $request->getParsedBody()['tipo_traslado_codigo'];

        $val11      = $request->getParsedBody()['tipo_posicion_codigo'];
        $val12      = $request->getParsedBody()['tipo_minuto_codigo'];
        $val13      = $request->getParsedBody()['tipo_campo_codigo'];

        $val14      = $request->getParsedBody()['tipo_cuerpo_zona_codigo'];
        $val15      = $request->getParsedBody()['tipo_cuerpo_lugar_codigo'];
        $val16      = $request->getParsedBody()['tipo_lesion_tipo_codigo'];
        $val17      = $request->getParsedBody()['tipo_lesion_origen_codigo'];
        $val18      = $request->getParsedBody()['tipo_lesion_reincidencia_codigo'];
        $val19      = $request->getParsedBody()['tipo_lesion_causa_codigo'];
        $val20      = $request->getParsedBody()['tipo_lesion_falta_codigo'];
        $val25      = $request->getParsedBody()['tipo_lesion_retiro_codigo'];

        $val21      = $request->getParsedBody()['tipo_diagnostico_tipo_codigo'];
        $val22      = $request->getParsedBody()['tipo_diagnostico_recuperacion_codigo'];
        $val23      = $request->getParsedBody()['tipo_diagnostico_tiempo_codigo'];
        $val24      = $request->getParsedBody()['diagnostico_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06)) {
            $sql00  = "INSERT INTO [lesion].[LESFIC](LESFICESC, LESFICCOC, LESFICJUC, LESFICEQC, LESFICPEC, LESFICFEC, LESFICCLI, LESFICTEM, LESFICDIS, LESFICTRA, LESFICPOS, LESFICMIN, LESFICCAM, LESFICCUZ, LESFICCUL, LESFICLES, LESFICORI, LESFICREI, LESFICRET, LESFICCAU, LESFICFAL, LESFICDIA, LESFICREC, LESFICTIE, LESFICOBD, LESFICAUS, LESFICAFH, LESFICAIP) VALUES (?, ?, ?, ?, ?, GETDATE(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val07, $val08, $val09, $val10, $val11, $val12, $val13, $val14, $val15, $val16, $val17, $val18, $val25, $val19, $val20, $val21, $val22, $val23, $val24, $aud01, $aud03]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $connMSSQL->lastInsertId()), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v1/601', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_concusion_codigo'];
        $val02      = $request->getParsedBody()['pregunta_concusion_codigo'];
        $val03      = $request->getParsedBody()['lesion_codigo'];
        $val04      = $request->getParsedBody()['lesion_concusion_respuesta'];
        $val05      = $request->getParsedBody()['lesion_concusion_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql00  = "INSERT INTO [lesion].[LESCON](LESCONTIC, LESCONPRC, LESCONLEC, LESCONRES, LESCONOBS, LESCONAUS, LESCONAFH, LESCONAIP) VALUES (?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $aud01, $aud03]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $connMSSQL->lastInsertId()), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });