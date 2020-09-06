function showMacAddress() {
    var obj = new ActiveXObject("WbemScripting.SWbemLocator");
    var s = obj.ConnectServer(".");
    var properties = s.ExecQuery("SELECT * FROM Win32_NetworkAdapterConfiguration");
    var e = new Enumerator(properties);
    var output;
    output = '<table border="0" cellPadding="5px" cellSpacing="1px" bgColor="#CCCCCC">';
     document.getElementById("box").innerHTML = output;
    output = output + '<tr bgColor="#EAEAEA"><td>Caption</td><td>MACAddress</td></tr>';
     document.getElementById("box").innerHTML = output;
    while (!e.atEnd()) {
        e.moveNext();
        var p = e.item();
        if (!p) continue;
        output = output + '<tr bgColor="#FFFFFF">';
        output = output + '<td>' + p.Caption; +'</td>';
        output = output + '<td>' + p.MACAddress + '</td>';
        output = output + '</tr>';
    }
    output = output + '</table>';
    
    document.getElementById("coco").innerHTML = output;
   console.log(output);
}

showMacAddress();