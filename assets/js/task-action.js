document.addEventListener("DOMContentLoaded", () => {
    const statuses = ['pending', 'in-progress', 'completed'];

    statuses.forEach(status => {
        const column = document.getElementById(status);
        if (column) {
            column.addEventListener("dragover", allowDrop);
            column.addEventListener("drop", drop);
        }
    });

    const tasks = document.querySelectorAll(".card.mb-2");
    tasks.forEach(task => {
        task.setAttribute("draggable", true);
        task.addEventListener("dragstart", drag);
    });
});

function allowDrop(event) {
    event.preventDefault();
}

function drag(event) {
    event.dataTransfer.setData("text", event.target.id);
}

async function drop(event) {
    event.preventDefault();
    const taskId = event.dataTransfer.getData("text");
    const taskElement = document.getElementById(taskId);
    const newStatus = event.currentTarget.id;

    if (taskElement && newStatus) {
        event.currentTarget.appendChild(taskElement);
        await postNewTaskStatus(taskId, newStatus);
    }
}

const postNewTaskStatus = async (id, status) => {
    try {
        const response = await fetch(`http://localhost:8000/api/task/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ status }),
        });

        if (!response.ok) {
            throw new Error('Failed to update task status');
        }
    } catch (error) {
        console.error(error);
    }
};
