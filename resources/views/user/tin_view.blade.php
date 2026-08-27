<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* Button styling */
        .print {
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
            padding: 10px 20px; /* Padding */
            font-size: 16px; /* Font size */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor */
            transition: background-color 0.3s ease; /* Smooth background color change */
        }

        /* Button hover effect */
        .print:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        /* Hide div_print_command by default */
        #div_print_command {
            display: none;
        }

        /* Print-only styles */
        @media print {
            #print, #div_print_command {
                display: none; /* Hide buttons during print */
            }
            @page {
                size: A4;
                margin: 20mm;
            }
        }
    </style>
</head>
<body>
    <div>
        {!! $htmlContent !!}
    </div>

    <!-- Div containing additional certificate options -->
    <div class="before_footer" id="div_print_command">
        <input type="button" id="btnPrint" name="btnPrint" value="Print Certificate" onclick="PrintCertificate()">
        <input type="button" id="btnSave" name="btnSave" value="Save Certificate" onclick="SaveCertificate()">
        <input type="button" id="btnEmail" name="btnEmail" value="Email Certificate" onclick="EmailCertificate()">
    </div>

    <!-- Button to toggle display of div_print_command -->
    <button class="print" id="print" onclick="window.print()">Download PDF</button>

    <script>
      function showprint() {
          document.getElementById("print").style.display = "block";
      }
    </script>

    <script>
      // Function to toggle the visibility of the div_print_command section
      function toggleCertificateOptions() {
          const divPrintCommand = document.getElementById("div_print_command");
          divPrintCommand.style.display = (divPrintCommand.style.display === "none" || divPrintCommand.style.display === "") 
              ? "block" 
              : "none";
      }
    </script>
</body>
</html>
