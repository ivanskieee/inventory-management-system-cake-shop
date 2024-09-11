<?php
    require('fpdf/fpdf.php');

    class PDF extends FPDF{
        function __construct(){
            parent::__construct('L');
        }
    
    function FancyTable($headers, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');

        $width_sum = 0;
        foreach($headers as $header_key => $header_data){
            $this->Cell($header_data['width'], 7, $header_key, 1, 0, 'C', true);
            $width_sum += $header_data['width'];
        }
       
        
        // for($i=0;$i<count($header);$i++)
        //     $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Color and font restoration
        $this->SetTextColor(0);
        $this->SetFont('');
    
        
        $img_pos_y = 40;
        $header_keys = array_keys($headers);
        foreach($data as $row){
            foreach($header_keys as $header_key){
                $content = $row[$header_key]['content'];
                $width = $headers[$header_key]['width'];
                $align = $row[$header_key]['align'];

          
            if($header_key == 'image')
                $content = ($content) || $content == "" ? '-' : $this->Image('.././uploads/products/' . $content, 45, $img_pos_y, 30,25);
                

               $this->Cell($width, 30, $content,'LRBT',0, $align);
               
            }
       
               $this->Ln();
               $img_pos_y += 30;
        }

        $this->Cell($width_sum,0,'','T');
       
        }
    }

    $type = $_GET['report'];
    $report_header = [
        'ingredient' => 'Ingredients Report',
        'product' => 'Products Report'
    ];

    include('connection.php');

    if($type == 'ingredient'){
        $headers = [
            'id' => [ 
                'width' => 15
            ],
            // 'image' => [ 
            //     'width' => 50
            // ], 
            'product_name' => [ 
                'width' => 50
            ], 
            'price' => [ 
                'width' => 15
            ], 
            'created_by' => [ 
                'width' => 45
            ], 
            'created_at' => [ 
                'width' => 50
            ], 
            'updated_at' => [ 
                'width' => 50
            ]
        ];

        
        $stmt = $conn->prepare("SELECT *, products.id as pid FROM products 
            INNER JOIN
                users ON
                products.created_by = users.id 
                ORDER BY
                products.created_at DESC");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $products = $stmt->fetchAll();


   
        $data = [];
        foreach($products as $product){
            $product['created_by'] = $product['first_name'] . ' ' . $product['last_name'];
            unset($product['first_name'], $product['last_name'], $product['password'], $product['email']);

            array_walk($product, function(&$str){
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            });

            $data[] = [
                'id' => [
                    'content' => $product['pid'],
                    'align' => 'C'
                ],
                // 'image' => [
                //     'content' => $product['img'],
                //     'align' => 'C'
                // ],
                'product_name' => [
                    'content' => $product['product_name'],
                    'align' => 'C'
                ],
                'price' => [
                    'content' => $product['price'],
                    'align' => 'C'
                ],
                'created_by' => [
                    'content' => $product['created_by'],
                    'align' => 'C'
                ],
                'created_at' => [
                    'content' => date('M d,Y h:i:s A', strtotime($product['created_at'])),
                    'align' => 'C'
                ],
                'updated_at' => [
                    'content' => date('M d,Y h:i:s A', strtotime($product['updated_at'])),
                    'align' => 'C'
                ]
                
            ];
        }
    }
    if($type == 'product'){
        $headers = [
            'id' => [ 
                'width' => 15
            ],
            // 'image' => [ 
            //     'width' => 18
            // ], 
            'product_name' => [ 
                'width' => 90
            ], 
            'price' => [ 
                'width' => 15
            ], 
            'created_by' => [ 
                'width' => 45
            ], 
            'created_at' => [ 
                'width' => 45
            ], 
            'updated_at' => [ 
                'width' => 45
            ]
        ];

        
        $stmt = $conn->prepare("SELECT *, productscake.id as pid FROM productscake 
            INNER JOIN
                users ON
                productscake.created_by = users.id 
                ORDER BY
                productscake.created_at DESC");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $products = $stmt->fetchAll();


   
        $data = [];
        foreach($products as $product){
            $product['created_by'] = $product['first_name'] . ' ' . $product['last_name'];
            unset($product['first_name'], $product['last_name'], $product['password'], $product['email']);

            array_walk($product, function(&$str){
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            });

            $data[] = [
                'id' => [
                    'content' => $product['pid'],
                    'align' => 'C'
                ],
                // 'image' => [
                //     'content' => $product['img'],
                //     'align' => 'C'
                // ],
                'product_name' => [
                    'content' => $product['product_name'],
                    'align' => 'C'
                ],
                'price' => [
                    'content' => $product['price'],
                    'align' => 'C'
                ],
                'created_by' => [
                    'content' => $product['created_by'],
                    'align' => 'C'
                ],
                'created_at' => [
                    'content' => date('M d,Y h:i:s A', strtotime($product['created_at'])),
                    'align' => 'L'
                ],
                'updated_at' => [
                    'content' => date('M d,Y h:i:s A', strtotime($product['updated_at'])),
                    'align' => 'L'
                ]
                
            ];
        }
    }

    $pdf = new PDF();
    $pdf->SetFont('Arial','',20);
    $pdf->AddPage();

    $pdf->Cell(80);
    $pdf->Cell(80,10, $report_header[$type] ,0,0,'C');
    $pdf->SetFont('Arial','',10);
    $pdf->Ln();
    $pdf->Ln();

    $pdf->FancyTable($headers, $data);
    $pdf->Output();