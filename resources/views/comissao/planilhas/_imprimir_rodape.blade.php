 <!-- Rodapé com colunas para usuário e conferente -->
 <div style="margin-top: 20px;">
     <table style="width: 100%;">
         <tr>
             <td> Valor Total : R$ {{ $valorTotalComissao }}</td>
         </tr>
     </table>
 </div>
 <!-- Rodapé com colunas para usuário e conferente -->
 <div style="margin-top: 100px;">
     <table style="width: 100%;">
         <tr>
             <td style="width: 50%;">{{ $planilha->colaborador->nome }}: ________________________</td>
             <td style="width: 50%;">Conferente: ________________________</td>
         </tr>
     </table>
 </div>

 <style>
     /* Adicione estilos CSS aqui para personalizar a aparência da tabela no PDF */
     .even-row {
         background-color: #e4e3e3;
         /* Cor para linhas pares */
     }

     .odd-row {
         background-color: #ffffff;
         /* Cor para linhas ímpares */
     }

     table {
         width: 100%;
         border-collapse: collapse;
         border: 0;
     }

     th,
     td {
         /* border: 1px solid #fff;*/
         padding: 8px;
         text-align: left;
         font-size: 10px;
         /* Tamanho da fonte */
     }


     th {
         /* background: #024280;*/
         background: #424242;
         color: #f2f2f2
     }

     .observacao-column {
         max-width: 200px;
         /* Remova as propriedades abaixo */
         /* overflow: hidden; */
         /* white-space: nowrap; */
         /* text-overflow: ellipsis; */
         /* Adicione a propriedade abaixo para permitir quebras de linha */
         word-wrap: break-word;
     }
 </style>
