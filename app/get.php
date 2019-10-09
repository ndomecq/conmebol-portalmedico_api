<?php
    $app->get('/v1/000', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.DOMFICCOD                     AS      tipo_codigo,
        a.DOMFICEST                     AS      tipo_estado_codigo,
        a.DOMFICORD                     AS      tipo_orden,
        a.DOMFICNOM                     AS      tipo_nombre,
        a.DOMFICVAL                     AS      tipo_dominio,
        a.DOMFICOBS                     AS      tipo_observacion,
        a.DOMFICAUS                     AS      tipo_usuario,
        a.DOMFICAFH                     AS      tipo_fecha_hora,
        a.DOMFICAIP                     AS      tipo_ip
        
        FROM [adm].[DOMFIC] a

        ORDER BY a.DOMFICVAL, a.DOMFICORD, a.DOMFICNOM";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                if ($rowMSSQL['tipo_estado_codigo'] === 'A') {
                    $tipo_estado_nombre = 'ACTIVO';
                } 
                
                if ($rowMSSQL['tipo_estado_codigo'] === 'I') {
                    $tipo_estado_nombre = 'INACTIVO';
                }

                $detalle    = array(
                    'tipo_codigo'           => $rowMSSQL['tipo_codigo'],
                    'tipo_estado_codigo'    => $rowMSSQL['tipo_estado_codigo'],
                    'tipo_estado_nombre'    => $tipo_estado_nombre,
                    'tipo_orden'            => $rowMSSQL['tipo_orden'],
                    'tipo_nombre'           => trim($rowMSSQL['tipo_nombre']),
                    'tipo_dominio'          => trim($rowMSSQL['tipo_dominio']),
                    'tipo_observacion'      => $rowMSSQL['tipo_observacion'],
                    'tipo_usuario'          => trim($rowMSSQL['tipo_usuario']),
                    'tipo_fecha_hora'       => $rowMSSQL['tipo_fecha_hora'],
                    'tipo_ip'               => $rowMSSQL['tipo_ip']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_codigo'           => '',
                    'tipo_estado_codigo'    => '',
                    'tipo_estado_nombre'    => '',
                    'tipo_orden'            => '',
                    'tipo_nombre'           => '',
                    'tipo_dominio'          => '',
                    'tipo_observacion'      => '',
                    'tipo_usuario'          => '',
                    'tipo_fecha_hora'       => '',
                    'tipo_ip'               => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.DOMFICCOD                     AS      tipo_codigo,
            a.DOMFICEST                     AS      tipo_estado_codigo,
            a.DOMFICORD                     AS      tipo_orden,
            a.DOMFICNOM                     AS      tipo_nombre,
            a.DOMFICVAL                     AS      tipo_dominio,
            a.DOMFICOBS                     AS      tipo_observacion,
            a.DOMFICAUS                     AS      tipo_usuario,
            a.DOMFICAFH                     AS      tipo_fecha_hora,
            a.DOMFICAIP                     AS      tipo_ip
            
            FROM [adm].[DOMFIC] a
            
            WHERE a.DOMFICCOD = ?
            
            ORDER BY a.DOMFICVAL, a.DOMFICORD, a.DOMFICNOM";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['tipo_estado_codigo'] === 'A') {
                        $tipo_estado_nombre = 'ACTIVO';
                    } 
                    
                    if ($rowMSSQL['tipo_estado_codigo'] === 'I') {
                        $tipo_estado_nombre = 'INACTIVO';
                    }
    
                    $detalle    = array(
                        'tipo_codigo'           => $rowMSSQL['tipo_codigo'],
                        'tipo_estado_codigo'    => $rowMSSQL['tipo_estado_codigo'],
                        'tipo_estado_nombre'    => $tipo_estado_nombre,
                        'tipo_orden'            => $rowMSSQL['tipo_orden'],
                        'tipo_nombre'           => trim($rowMSSQL['tipo_nombre']),
                        'tipo_dominio'          => trim($rowMSSQL['tipo_dominio']),
                        'tipo_observacion'      => $rowMSSQL['tipo_observacion'],
                        'tipo_usuario'          => trim($rowMSSQL['tipo_usuario']),
                        'tipo_fecha_hora'       => $rowMSSQL['tipo_fecha_hora'],
                        'tipo_ip'               => $rowMSSQL['tipo_ip']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'           => '',
                        'tipo_estado_codigo'    => '',
                        'tipo_estado_nombre'    => '',
                        'tipo_orden'            => '',
                        'tipo_nombre'           => '',
                        'tipo_dominio'          => '',
                        'tipo_observacion'      => '',
                        'tipo_usuario'          => '',
                        'tipo_fecha_hora'       => '',
                        'tipo_ip'               => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/dominio/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.DOMFICCOD                     AS      tipo_codigo,
            a.DOMFICEST                     AS      tipo_estado_codigo,
            a.DOMFICORD                     AS      tipo_orden,
            a.DOMFICNOM                     AS      tipo_nombre,
            a.DOMFICVAL                     AS      tipo_dominio,
            a.DOMFICOBS                     AS      tipo_observacion,
            a.DOMFICAUS                     AS      tipo_usuario,
            a.DOMFICAFH                     AS      tipo_fecha_hora,
            a.DOMFICAIP                     AS      tipo_ip
            
            FROM [adm].[DOMFIC] a
            
            WHERE a.DOMFICVAL = ?

            ORDER BY a.DOMFICVAL, a.DOMFICORD, a.DOMFICNOM";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['tipo_estado_codigo'] === 'A') {
                        $tipo_estado_nombre = 'ACTIVO';
                    } 
                    
                    if ($rowMSSQL['tipo_estado_codigo'] === 'I') {
                        $tipo_estado_nombre = 'INACTIVO';
                    }
    
                    $detalle    = array(
                        'tipo_codigo'           => $rowMSSQL['tipo_codigo'],
                        'tipo_estado_codigo'    => $rowMSSQL['tipo_estado_codigo'],
                        'tipo_estado_nombre'    => $tipo_estado_nombre,
                        'tipo_orden'            => $rowMSSQL['tipo_orden'],
                        'tipo_nombre'           => trim($rowMSSQL['tipo_nombre']),
                        'tipo_dominio'          => trim($rowMSSQL['tipo_dominio']),
                        'tipo_observacion'      => $rowMSSQL['tipo_observacion'],
                        'tipo_usuario'          => trim($rowMSSQL['tipo_usuario']),
                        'tipo_fecha_hora'       => $rowMSSQL['tipo_fecha_hora'],
                        'tipo_ip'               => $rowMSSQL['tipo_ip']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'           => '',
                        'tipo_estado_codigo'    => '',
                        'tipo_estado_nombre'    => '',
                        'tipo_orden'            => '',
                        'tipo_nombre'           => '',
                        'tipo_dominio'          => '',
                        'tipo_observacion'      => '',
                        'tipo_usuario'          => '',
                        'tipo_fecha_hora'       => '',
                        'tipo_ip'               => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/auditoria/{dominio}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('dominio');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.DOMFICACOD                    AS      auditoria_codigo,
            a.DOMFICAMET                    AS      auditoria_metodo,
            a.DOMFICAUSU                    AS      auditoria_usuario,
            a.DOMFICAFEC                    AS      auditoria_fecha_hora,
            a.DOMFICADIP                    AS      auditoria_ip,

            a.DOMFICACODOLD                 AS      auditoria_antes_tipo_codigo,
            a.DOMFICAESTOLD                 AS      auditoria_antes_tipo_estado_codigo,
            a.DOMFICAORDOLD                 AS      auditoria_antes_tipo_orden,
            a.DOMFICANOMOLD                 AS      auditoria_antes_tipo_nombre,
            a.DOMFICAVALOLD                 AS      auditoria_antes_tipo_dominio,
            a.DOMFICAOBSOLD                 AS      auditoria_antes_tipo_observacion,

            a.DOMFICACODNEW                 AS      auditoria_despues_tipo_codigo,
            a.DOMFICAESTNEW                 AS      auditoria_despues_tipo_estado_codigo,
            a.DOMFICAORDNEW                 AS      auditoria_despues_tipo_orden,
            a.DOMFICANOMNEW                 AS      auditoria_despues_tipo_nombre,
            a.DOMFICAVALNEW                 AS      auditoria_despues_tipo_dominio,
            a.DOMFICAOBSNEW                 AS      auditoria_despues_tipo_observacion
            
            FROM [adm].[DOMFIC] a
            
            WHERE a.DOMFICAVALOLD = ? OR a.DOMFICAVALNEW = ?
            
            ORDER BY a.DOMFICACOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['auditoria_antes_tipo_estado_codigo'] === 'A') {
                        $tipo_estado_nombre_antes   = 'ACTIVO';
                    }

                    if ($rowMSSQL['auditoria_antes_tipo_estado_codigo'] === 'I') {
                        $tipo_estado_nombre_antes   = 'INACTIVO';
                    }

                    if ($rowMSSQL['auditoria_despues_tipo_estado_codigo'] === 'A') {
                        $tipo_estado_nombre_despues = 'ACTIVO';
                    }

                    if ($rowMSSQL['auditoria_despues_tipo_estado_codigo'] === 'I') {
                        $tipo_estado_nombre_despues = 'INACTIVO';
                    }

                    $detalle    = array(
                        'auditoria_codigo'                      => $rowMSSQL['auditoria_codigo'],
                        'auditoria_metodo'                      => $rowMSSQL['auditoria_metodo'],
                        'auditoria_usuario'                     => trim($rowMSSQL['auditoria_usuario']),
                        'auditoria_fecha_hora'                  => $rowMSSQL['auditoria_fecha_hora'],
                        'auditoria_ip'                          => $rowMSSQL['auditoria_ip'],

                        'auditoria_antes_tipo_codigo'           => $rowMSSQL['auditoria_antes_tipo_codigo'],
                        'auditoria_antes_tipo_estado_codigo'    => $rowMSSQL['auditoria_antes_tipo_estado_codigo'],
                        'auditoria_antes_tipo_estado_nombre'    => $tipo_estado_nombre_antes,
                        'auditoria_antes_tipo_orden'            => $rowMSSQL['auditoria_antes_tipo_orden'],
                        'auditoria_antes_tipo_nombre'           => trim($rowMSSQL['auditoria_antes_tipo_nombre']),
                        'auditoria_antes_tipo_dominio'          => trim($rowMSSQL['auditoria_antes_tipo_dominio']),
                        'auditoria_antes_tipo_observacion'      => $rowMSSQL['auditoria_antes_tipo_observacion'],

                        'auditoria_despues_tipo_codigo'         => $rowMSSQL['auditoria_despues_tipo_codigo'],
                        'auditoria_despues_tipo_estado_codigo'  => $rowMSSQL['auditoria_despues_tipo_estado_codigo'],
                        'auditoria_despues_tipo_estado_nombre'  => $tipo_estado_nombre_despues,
                        'auditoria_despues_tipo_orden'          => $rowMSSQL['auditoria_despues_tipo_orden'],
                        'auditoria_despues_tipo_nombre'         => $rowMSSQL['auditoria_despues_tipo_nombre'],
                        'auditoria_despues_tipo_dominio'        => $rowMSSQL['auditoria_despues_tipo_dominio'],
                        'auditoria_despues_tipo_observacion'    => $rowMSSQL['auditoria_despues_tipo_observacion']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'auditoria_codigo'                      => '',
                        'auditoria_metodo'                      => '',
                        'auditoria_usuario'                     => '',
                        'auditoria_fecha_hora'                  => '',
                        'auditoria_ip'                          => '',
                        'auditoria_antes_tipo_codigo'           => '',
                        'auditoria_antes_tipo_estado_codigo'    => '',
                        'auditoria_antes_tipo_estado_nombre'    => '',
                        'auditoria_antes_tipo_orden'            => '',
                        'auditoria_antes_tipo_nombre'           => '',
                        'auditoria_antes_tipo_dominio'          => '',
                        'auditoria_antes_tipo_observacion'      => '',
                        'auditoria_despues_tipo_codigo'         => '',
                        'auditoria_despues_tipo_estado_codigo'  => '',
                        'auditoria_despues_tipo_estado_nombre'  => '',
                        'auditoria_despues_tipo_orden'          => '',
                        'auditoria_despues_tipo_nombre'         => '',
                        'auditoria_despues_tipo_dominio'        => '',
                        'auditoria_despues_tipo_observacion'    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/200/disciplina/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.competitionFifaId                 AS          competicion_codigo,
            a.superiorCompetitionFifaId         AS          competicion_codigo_padre,
            a.status                            AS          competicion_estado,
            a.internationalName                 AS          competicion_nombre,
            a.internationalShortName            AS          competicion_nombre_corto,
            a.season                            AS          competicion_anho,
            a.ageCategory                       AS          competicion_categoria_codigo,
            a.ageCategoryName                   AS          competicion_categoria_nombre,
            a.dateFrom                          AS          competicion_desde,
            a.dateTo                            AS          competicion_hasta,
            a.discipline                        AS          competicion_disciplina,
            a.gender                            AS          competicion_genero,
            a.imageId                           AS          competicion_imagen_codigo,
            a.multiplier                        AS          competicion_multiplicador,
            a.nature                            AS          competicion_naturaleza,
            a.numberOfParticipants              AS          competicion_numero_participante,
            a.orderNumber                       AS          competicion_numero_orden,
            a.teamCharacter                     AS          competicion_equipo_tipo,
            a.flyingSubstitutions               AS          competicion_sustitucion,
            a.penaltyShootout                   AS          competicion_penal,
            a.matchType                         AS          competicion_tipo,
            a.pictureContentType                AS          competicion_imagen_tipo,
            a.pictureLink                       AS          competicion_image_link,
            a.pictureValue                      AS          competicion_imagen_valor,
            a.lastUpdate                        AS          competicion_ultima_actualizacion,

            b.organisationFifaId                AS          organizacion_codigo,
            b.organisationName                  AS          organizacion_nombre
            
            FROM [comet].[competitions] a
            LEFT JOIN [comet].[organisations] b ON a.organisationFifaId = b.organisationFifaId
            
            WHERE a.superiorCompetitionFifaId IS NULL AND a.discipline = ?

            ORDER BY a.discipline, a.season, a.competitionFifaId";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {    
                    $detalle    = array(
                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'              => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                    => trim($rowMSSQL['competicion_estado']),
                        'competicion_nombre'                    => trim($rowMSSQL['competicion_nombre']),
                        'competicion_nombre_corto'              => trim($rowMSSQL['competicion_nombre_corto']),
                        'competicion_anho'                      => $rowMSSQL['competicion_anho'],
                        'competicion_categoria_codigo'          => trim($rowMSSQL['competicion_categoria_codigo']),
                        'competicion_categoria_nombre'          => trim($rowMSSQL['competicion_categoria_nombre']),
                        'competicion_desde'                     => $rowMSSQL['competicion_desde'],
                        'competicion_hasta'                     => $rowMSSQL['competicion_hasta'],
                        'competicion_disciplina'                => trim($rowMSSQL['competicion_disciplina']),
                        'competicion_genero'                    => trim($rowMSSQL['competicion_genero']),
                        'competicion_imagen_codigo'             => $rowMSSQL['competicion_imagen_codigo'],
                        'competicion_multiplicador'             => $rowMSSQL['competicion_multiplicador'],
                        'competicion_naturaleza'                => trim($rowMSSQL['competicion_naturaleza']),
                        'competicion_numero_participante'       => $rowMSSQL['competicion_numero_participante'],
                        'competicion_numero_orden'              => $rowMSSQL['competicion_numero_orden'],
                        'competicion_equipo_tipo'               => trim($rowMSSQL['competicion_equipo_tipo']),
                        'competicion_sustitucion'               => $rowMSSQL['competicion_sustitucion'],
                        'competicion_penal'                     => $rowMSSQL['competicion_penal'],
                        'competicion_tipo'                      => trim($rowMSSQL['competicion_tipo']),
                        'competicion_imagen_tipo'               => trim($rowMSSQL['competicion_imagen_tipo']),
                        'competicion_image_link'                => trim($rowMSSQL['competicion_image_link']),
                        'competicion_imagen_valor'              => trim($rowMSSQL['competicion_imagen_valor']),
                        'competicion_ultima_actualizacion'      => $rowMSSQL['competicion_ultima_actualizacion'],
                        'organizacion_codigo'                   => $rowMSSQL['organizacion_codigo'],
                        'organizacion_nombre'                   => trim($rowMSSQL['organizacion_nombre'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'competicion_codigo'                    => '',
                        'competicion_codigo_padre'              => '',
                        'competicion_estado'                    => '',
                        'competicion_nombre'                    => '',
                        'competicion_nombre_corto'              => '',
                        'competicion_anho'                      => '',
                        'competicion_categoria_codigo'          => '',
                        'competicion_categoria_nombre'          => '',
                        'competicion_desde'                     => '',
                        'competicion_hasta'                     => '',
                        'competicion_disciplina'                => '',
                        'competicion_genero'                    => '',
                        'competicion_imagen_codigo'             => '',
                        'competicion_multiplicador'             => '',
                        'competicion_naturaleza'                => '',
                        'competicion_numero_participante'       => '',
                        'competicion_numero_orden'              => '',
                        'competicion_equipo_tipo'               => '',
                        'competicion_sustitucion'               => '',
                        'competicion_penal'                     => '',
                        'competicion_tipo'                      => '',
                        'competicion_imagen_tipo'               => '',
                        'competicion_image_link'                => '',
                        'competicion_imagen_valor'              => '',
                        'competicion_ultima_actualizacion'      => '',
                        'organizacion_codigo'                   => '',
                        'organizacion_nombre'                   => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/200/competicion/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.competitionFifaId                 AS          competicion_codigo,
            a.superiorCompetitionFifaId         AS          competicion_codigo_padre,
            a.status                            AS          competicion_estado,
            a.internationalName                 AS          competicion_nombre,
            a.internationalShortName            AS          competicion_nombre_corto,
            a.season                            AS          competicion_anho,
            a.ageCategory                       AS          competicion_categoria_codigo,
            a.ageCategoryName                   AS          competicion_categoria_nombre,
            a.dateFrom                          AS          competicion_desde,
            a.dateTo                            AS          competicion_hasta,
            a.discipline                        AS          competicion_disciplina,
            a.gender                            AS          competicion_genero,
            a.imageId                           AS          competicion_imagen_codigo,
            a.multiplier                        AS          competicion_multiplicador,
            a.nature                            AS          competicion_naturaleza,
            a.numberOfParticipants              AS          competicion_numero_participante,
            a.orderNumber                       AS          competicion_numero_orden,
            a.teamCharacter                     AS          competicion_equipo_tipo,
            a.flyingSubstitutions               AS          competicion_sustitucion,
            a.penaltyShootout                   AS          competicion_penal,
            a.matchType                         AS          competicion_tipo,
            a.pictureContentType                AS          competicion_imagen_tipo,
            a.pictureLink                       AS          competicion_image_link,
            a.pictureValue                      AS          competicion_imagen_valor,
            a.lastUpdate                        AS          competicion_ultima_actualizacion,

            b.organisationFifaId                AS          organizacion_codigo,
            b.organisationName                  AS          organizacion_nombre
            
            FROM [comet].[competitions] a
            LEFT JOIN [comet].[organisations] b ON a.organisationFifaId = b.organisationFifaId
            
            WHERE a.superiorCompetitionFifaId = ?

            ORDER BY a.discipline, a.season, a.competitionFifaId";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {    
                    $detalle    = array(
                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'              => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                    => trim($rowMSSQL['competicion_estado']),
                        'competicion_nombre'                    => trim($rowMSSQL['competicion_nombre']),
                        'competicion_nombre_corto'              => trim($rowMSSQL['competicion_nombre_corto']),
                        'competicion_anho'                      => $rowMSSQL['competicion_anho'],
                        'competicion_categoria_codigo'          => trim($rowMSSQL['competicion_categoria_codigo']),
                        'competicion_categoria_nombre'          => trim($rowMSSQL['competicion_categoria_nombre']),
                        'competicion_desde'                     => $rowMSSQL['competicion_desde'],
                        'competicion_hasta'                     => $rowMSSQL['competicion_hasta'],
                        'competicion_disciplina'                => trim($rowMSSQL['competicion_disciplina']),
                        'competicion_genero'                    => trim($rowMSSQL['competicion_genero']),
                        'competicion_imagen_codigo'             => $rowMSSQL['competicion_imagen_codigo'],
                        'competicion_multiplicador'             => $rowMSSQL['competicion_multiplicador'],
                        'competicion_naturaleza'                => trim($rowMSSQL['competicion_naturaleza']),
                        'competicion_numero_participante'       => $rowMSSQL['competicion_numero_participante'],
                        'competicion_numero_orden'              => $rowMSSQL['competicion_numero_orden'],
                        'competicion_equipo_tipo'               => trim($rowMSSQL['competicion_equipo_tipo']),
                        'competicion_sustitucion'               => $rowMSSQL['competicion_sustitucion'],
                        'competicion_penal'                     => $rowMSSQL['competicion_penal'],
                        'competicion_tipo'                      => trim($rowMSSQL['competicion_tipo']),
                        'competicion_imagen_tipo'               => trim($rowMSSQL['competicion_imagen_tipo']),
                        'competicion_image_link'                => trim($rowMSSQL['competicion_image_link']),
                        'competicion_imagen_valor'              => trim($rowMSSQL['competicion_imagen_valor']),
                        'competicion_ultima_actualizacion'      => $rowMSSQL['competicion_ultima_actualizacion'],
                        'organizacion_codigo'                   => $rowMSSQL['organizacion_codigo'],
                        'organizacion_nombre'                   => trim($rowMSSQL['organizacion_nombre'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'competicion_codigo'                    => '',
                        'competicion_codigo_padre'              => '',
                        'competicion_estado'                    => '',
                        'competicion_nombre'                    => '',
                        'competicion_nombre_corto'              => '',
                        'competicion_anho'                      => '',
                        'competicion_categoria_codigo'          => '',
                        'competicion_categoria_nombre'          => '',
                        'competicion_desde'                     => '',
                        'competicion_hasta'                     => '',
                        'competicion_disciplina'                => '',
                        'competicion_genero'                    => '',
                        'competicion_imagen_codigo'             => '',
                        'competicion_multiplicador'             => '',
                        'competicion_naturaleza'                => '',
                        'competicion_numero_participante'       => '',
                        'competicion_numero_orden'              => '',
                        'competicion_equipo_tipo'               => '',
                        'competicion_sustitucion'               => '',
                        'competicion_penal'                     => '',
                        'competicion_tipo'                      => '',
                        'competicion_imagen_tipo'               => '',
                        'competicion_image_link'                => '',
                        'competicion_imagen_valor'              => '',
                        'competicion_ultima_actualizacion'      => '',
                        'organizacion_codigo'                   => '',
                        'organizacion_nombre'                   => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });