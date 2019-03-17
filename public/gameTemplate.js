// FPS игры
fps(30);

var m = engine.getMousePosition();

function update()
{
    m = engine.getMousePosition();

    draw();
}

function draw()
{
    context.clear();
    
    //Пример (можно удалить)
    context.fillStyle = "green";
    context.fillRect(m.x, m.y, 100, 100);
    // Начинайте
}