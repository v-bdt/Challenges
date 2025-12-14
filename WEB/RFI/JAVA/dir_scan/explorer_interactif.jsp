<%@ page import="java.io.*, java.util.*" %>
<%
    String dir  = request.getParameter("dir");
    String file = request.getParameter("file");

    if (dir == null || dir.isEmpty()) {
        dir = ".";
    }

    /* Fonctions utilitaires */
    String formatSize(long bytes) {
        String[] units = {"o", "Ko", "Mo", "Go"};
        int i = 0;
        double size = bytes;
        while (size >= 1024 && i < units.length - 1) {
            size /= 1024;
            i++;
        }
        return String.format("%.2f %s", size, units[i]);
    }

    void afficherArborescence(File dossier, JspWriter out) throws IOException {
        if (!dossier.isDirectory()) return;

        File[] elements = dossier.listFiles();
        if (elements == null) return;

        out.println("<ul>");
        for (File f : elements) {
            String name = f.getName();
            String path = f.getPath().replace("\\", "/");

            if (f.isDirectory()) {
                out.println("<li>📁");
                out.println("<form method='post' style='display:inline'>");
                out.println("<input type='hidden' name='dir' value='" + path + "'>");
                out.println("<button type='submit'>" + name + "</button>");
                out.println("</form>");
                afficherArborescence(f, out);
                out.println("</li>");
            } else {
                out.println("<li>📄");
                out.println("<form method='post' style='display:inline'>");
                out.println("<input type='hidden' name='dir' value='" + dossier.getPath().replace("\\", "/") + "'>");
                out.println("<input type='hidden' name='file' value='" + name + "'>");
                out.println("<button type='submit'>" + name + "</button>");
                out.println("</form>");

                out.println("<span class='info'>(" +
                        formatSize(f.length()) + " • " +
                        new Date(f.lastModified()) + " • " +
                        (f.canRead() ? "r" : "-") +
                        (f.canWrite() ? "w" : "-") +
                        ")</span>");
                out.println("</li>");
            }
        }
        out.println("</ul>");
    }
%>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Explorateur JSP</title>
<style>
body { font-family: Arial; background: #f4f4f4; padding: 20px; }
ul { list-style: none; padding-left: 20px; }
li { margin: 4px 0; }
button { background: none; border: none; color: #0066cc; cursor: pointer; padding: 0; }
button:hover { text-decoration: underline; }
.info { color: #666; font-size: 0.85em; margin-left: 5px; }
pre { background: #222; color: #eee; padding: 15px; overflow: auto; }
.box { background: white; padding: 15px; border-radius: 6px; }
input[type=text] { width: 400px; }
</style>
</head>

<body>

<div class="box">
<h2>📂 Explorateur de fichiers (JSP)</h2>

<!-- Formulaire principal -->
<form method="post">
    <label>Dossier :</label><br>
    <input type="text" name="dir" value="<%= dir %>"><br><br>

    <label>Fichier :</label><br>
    <input type="text" name="file" value="<%= file != null ? file : "" %>"><br><br>

    <button type="submit">🔍 Explorer</button>
</form>

<hr>

<!-- Bouton dossier parent -->
<form method="post">
    <input type="hidden" name="dir" value="<%= new File(dir).getParent() %>">
    <button type="submit">⬅ Dossier parent</button>
</form>

<br>

<!-- Arborescence -->
<%
    afficherArborescence(new File(dir), out);
%>
</div>

<!-- Affichage fichier -->
<%
    if (file != null && !file.isEmpty()) {
        File f = new File(dir, file);
        if (f.isFile()) {
%>
<div class="box">
    <h3>📄 <%= file %></h3>
    <pre>
<%
            BufferedReader reader = new BufferedReader(new FileReader(f));
            String line;
            while ((line = reader.readLine()) != null) {
                out.println(line.replace("<", "&lt;").replace(">", "&gt;"));
            }
            reader.close();
%>
    </pre>
</div>
<%
        }
    }
%>

</body>
</html>
