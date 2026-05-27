<?php

namespace Model;

class Poliza extends ActiveRecord {
    protected static $tabla = 'poliza';
    protected static $columnasDB = [
        'id',
        'id_empresa',
        'numero_poliza',
        'tipo_plan',
        'costo',
        'monto_cobertura',
        'poliza_pdf',
        'periodo',
        'estatus',
        'fecha_inicio',
        'fecha_vencimiento'
    ];

    public $id;
    public $id_empresa;
    public $numero_poliza;
    public $tipo_plan;
    public $costo;
    public $monto_cobertura;
    public $poliza_pdf;
    public $periodo;
    public $estatus;
    public $fecha_inicio;
    public $fecha_vencimiento;
    //atributos fuera de la DB
    public $empresa;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_empresa = $args['id_empresa'] ?? null;
        $this->numero_poliza = $args['numero_poliza'] ?? '';
        $this->tipo_plan = $args['tipo_plan'] ?? '';
        $this->costo = $args['costo'] ?? '';
        $this->monto_cobertura = $args['monto_cobertura'] ?? '';
        $this->poliza_pdf = $args['poliza_pdf'] ?? '';
        $this->periodo = $args['periodo'] ?? '';
        $this->estatus = $args['estatus'] ?? '';
        $this->fecha_inicio = $args['fecha_inicio'] ?? '';
        $this->fecha_vencimiento = $args['fecha_vencimiento'] ?? '';
    }

    public function validarNuevaPoliza() {

        if (!$this->id_empresa) {
            self::$alertas['error'][] = 'Debes seleccionar una empresa';
        }

        if (!$this->numero_poliza) {
            self::$alertas['error'][] = 'El número de póliza es obligatorio';
        } else if ($this->numero_poliza && !ctype_digit($this->numero_poliza) && $this->numero_poliza < 0) {
            self::$alertas['error'][] = 'El número de póliza solo debe contener números';
        }

        if (!$this->tipo_plan) {
            self::$alertas['error'][] = 'Selecciona un tipo de plan';
        }

        if (!$this->costo) {
            self::$alertas['error'][] = 'El costo de la póliza es obligatorio';
        } elseif (!is_numeric($this->costo) && $this->costo < 0) {
            self::$alertas['error'][] = 'El costo debe ser un valor numérico válido';
        }

        if (!$this->monto_cobertura) {
            self::$alertas['error'][] = 'El monto de cobertura es obligatorio';
        } elseif (!is_numeric($this->monto_cobertura) && $this->monto_cobertura < 0) {
            self::$alertas['error'][] = 'El monto de cobertura debe ser un valor numérico';
        }

        if (!$this->periodo) {
            self::$alertas['error'][] = 'Selecciona el periodo del plan';
        }

        if (!$this->fecha_inicio) {
            self::$alertas['error'][] = 'La fecha de inicio es obligatoria';
        }

        if (!$this->fecha_vencimiento) {
            self::$alertas['error'][] = 'La fecha de vencimiento es obligatoria';
        }

        //Validacion de la carga de PDF
        if(empty(self::$alertas['error'])) {
            if($_FILES['poliza_pdf']['error'] === 4) {
                self::$alertas['error'][] = 'Debes cargar el documento de la póliza en PDF';
            } else if($_FILES['poliza_pdf']['error'] === 0) {
                if($_FILES['poliza_pdf']['type'] !== 'application/pdf') {
                    self::$alertas['error'][] = 'El archivo debe ser un formato PDF válido';
                }
                if($_FILES['poliza_pdf']['size'] > 2 * 1024 * 1024) {
                    self::$alertas['error'][] = 'El archivo es muy pesado. Máximo 2MB';
                }
            } else {
                self::$alertas['error'][] = 'Hubo un error al cargar el archivo';
            }
        }

        //Validaciones de Costo y Cobertura
        if(empty(self::$alertas['error'])) {
            if ($this->monto_cobertura < 50000) {
                self::$alertas['error'][] = 'El monto de cobertura es demasiado bajo (Mínimo $50,000)';
            }

            if ($this->costo < 500) {
                self::$alertas['error'][] = 'El costo de la póliza no puede ser menor a $500';
            }

            if ($this->costo >= $this->monto_cobertura) {
                self::$alertas['error'][] = 'El costo no puede ser mayor o igual al monto de cobertura';
            }

            if ($this->monto_cobertura <= $this->costo) {
                self::$alertas['error'][] = 'El monto de cobertura no puede ser menor o igual al costo de la póliza';
            }
            
            //Validacion de fechas correctas
            $inicio = strtotime($this->fecha_inicio);
            $vencimiento = strtotime($this->fecha_vencimiento);
            $hoy = strtotime(date('Y-m-d'));
    
            if ($inicio < $hoy) {
                self::$alertas['error'][] = 'La fecha de inicio no puede ser una fecha pasada u omitirse';
            }
            if ($vencimiento <= $inicio) {
                self::$alertas['error'][] = 'La fecha de vencimiento debe ser posterior a la de inicio';
            }

            //Validacion de Varianza por Periodo
            $this->validarVarianzaPeriodo($inicio, $vencimiento);

            //Validaciones de duplicados de numero de poliza y poliza vigente
            $this->existePolizaVigente();
            $this->numeroPolizaUnico();
        }

        return self::$alertas;
    }

    public function validarEditarPoliza() {
        if (!$this->tipo_plan) {
            self::$alertas['error'][] = 'Selecciona un tipo de plan';
        }
        if (!$this->costo) {
            self::$alertas['error'][] = 'El costo de la póliza es obligatorio';
        }
        if (!$this->monto_cobertura) {
            self::$alertas['error'][] = 'El monto de cobertura es obligatorio';
        }
        if (!$this->periodo) {
            self::$alertas['error'][] = 'Selecciona el periodo del plan';
        }
        if (!$this->fecha_inicio) {
            self::$alertas['error'][] = 'La fecha de inicio es obligatoria';
        }
        if (!$this->fecha_vencimiento) {
            self::$alertas['error'][] = 'La fecha de vencimiento es obligatoria';
        }

        if(empty(self::$alertas['error'])) {
            if($_FILES['poliza_pdf']['error'] !== 4) {
                if($_FILES['poliza_pdf']['error'] === 0) {
                    if($_FILES['poliza_pdf']['type'] !== 'application/pdf') {
                        self::$alertas['error'][] = 'El archivo debe ser un formato PDF válido';
                    }
                    if($_FILES['poliza_pdf']['size'] > 2 * 1024 * 1024) {
                        self::$alertas['error'][] = 'El archivo es muy pesado. Máximo 2MB';
                    }
                } else {
                    self::$alertas['error'][] = 'Hubo un error técnico al cargar el nuevo archivo';
                }
            }
        }

        if(empty(self::$alertas['error'])) {
            if ($this->monto_cobertura < 50000) {
                self::$alertas['error'][] = 'El monto de cobertura mínimo es de $50,000';
            }

            if ($this->costo < 500) {
                self::$alertas['error'][] = 'El costo de la póliza no puede ser menor a $500';
            }
            
            if ($this->costo >= $this->monto_cobertura) {
                self::$alertas['error'][] = 'El costo no puede ser mayor o igual a la cobertura';
            }
            
            $inicio = strtotime($this->fecha_inicio);
            $vencimiento = strtotime($this->fecha_vencimiento);
            $hoy = strtotime(date('Y-m-d'));

            if ($inicio < $hoy) {
                self::$alertas['error'][] = 'La fecha de inicio no puede ser anterior a hoy';
            }

            if ($vencimiento <= $inicio) {
                self::$alertas['error'][] = 'La fecha de vencimiento debe ser posterior al inicio';
            }

            $this->validarVarianzaPeriodo($inicio, $vencimiento);
        }

        return self::$alertas;
}

    private function validarVarianzaPeriodo($inicio, $vencimiento) {
        if(!$this->periodo) return;

        $diffDiasReal = floor(($vencimiento - $inicio) / 86400);
        
        $periodosDias = [
            'Mensual' => 30,
            'Bimestral' => 60,
            'Trimestral' => 90,
            'Tetramestral' => 120,
            'Semestral' => 180,
            'Anual' => 365
        ];

        if(isset($periodosDias[$this->periodo])) {
            $diasTeoricos = $periodosDias[$this->periodo];
            $varianza = abs($diffDiasReal - $diasTeoricos);

            if ($varianza > 3) {
                self::$alertas['error'][] = "La fecha de vencimiento no coincide con el periodo '{$this->periodo}'. Diferencia permitida: 3 días.";
            }
        }
    }

    public function existePolizaVigente() {
        $id_empresa = self::$db->escape_string($this->id_empresa ?? '');
        $id = self::$db->escape_string($this->id ?? '');

        $query = "SELECT * FROM " . self::$tabla . " WHERE id_empresa = '{$id_empresa}' ";
        $query .= " AND estatus = 'Vigente' AND id != '{$id}' LIMIT 1";
        
        $resultado = self::$db->query($query);
        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'Esta empresa ya tiene una póliza vigente registrada';
        }
    }

    public function numeroPolizaUnico() {
        $numero_poliza = self::$db->escape_string($this->numero_poliza ?? '');
        $id = self::$db->escape_string($this->id ?? '');

        $query = "SELECT * FROM " . self::$tabla . " WHERE numero_poliza = '{$numero_poliza}' ";
        $query .= " AND id != '{$id}' LIMIT 1";
        
        $resultado = self::$db->query($query);
        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'El número de póliza ya existe en el sistema';
        }
    }

    public function cargarEmpresa() {
        $this->empresa = Empresa::find($this->id_empresa);
    }

    public function empresaInactiva() {
        $query = "SELECT estatus FROM empresa WHERE id = '" . self::$db->escape_string($this->id_empresa) . "' AND estatus = 'Inactiva' LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado->num_rows > 0;
    }

    public static function findVigenteByEmpresa($id_empresa) {
        // 1. Construir la consulta SQL
        $query = "SELECT * FROM poliza WHERE id_empresa = " . (int)$id_empresa . " AND estatus = 'Vigente' LIMIT 1";
        
        // 2. Usar tu función nativa de ActiveRecord para obtener un array de objetos Poliza
        $resultado = self::consultarSQL($query);
        
        // 3. Como usar 'LIMIT 1' siempre traerá un array de un solo elemento (o vacío),
        // usamos array_shift para extraer y retornar directamente el objeto Poliza, o NULL si no encontró nada.
        return array_shift($resultado); 
    }
}