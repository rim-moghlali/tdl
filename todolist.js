function showCompletedTodos(){
    let completedTodosSection = document.getElementById('completedTodos');
    completedTodosSection.setAttribute('opened', '');
}

function showAllTodos(){
    let completedTodosSection = document.getElementById('completedTodos');
    completedTodosSection.removeAttribute('opened');
}


async function deleteTodolistById(todolistId) {
    if (confirm("Are you sure?") == true) {

        console.log('deleted todolist by id = ', todolistId);
    
        let response = await fetch('api/tdl_delete_todolist.php?id='+ todolistId);
        let deleteRes = await response.json();
    
        let todolistEl = document.querySelector(`.todo-list[data-id="${todolistId}"]`);
    
        if (deleteRes.success == "yes") {
            todolistEl.remove();
        }
        
        console.log(todolistEl);
        console.log(deleteRes);
    }

}


async function deleteTaskById(taskId) {
    console.log('deleted task by id = ', taskId);

    if (confirm("Are you sure?") == true) {

        console.log('deleted task by id = ', taskId);
    
        let response = await fetch('api/tdl_delete_task.php?id='+ taskId);
        let deleteRes = await response.json();
    
        let taskEl = document.querySelector(`.todo-data[data-task-id="${taskId}"]`);
    
        if (deleteRes.success == "yes") {
            taskEl.remove();
        }
    
        console.log(taskEl);
        console.log(deleteRes);
    }

}




async function completeTaskById(taskId, taskEl) {

    console.log('completed task by id = ', taskId, taskEl);

    let response = await fetch('api/tdl_complete_task.php?id='+ taskId);
    let completeRes = await response.json();


    if (completeRes.success == "yes") {
        // get the checkbox input of this task element
        //let checkboxEl = taskEl.querySelector('.');
        // check it now! #lol
        //checkboxEl.checked = true;
        
        taskEl.setAttribute('completed', '');
    }

    console.log(taskEl);
    console.log(completeRes);

}


async function undoTaskById(taskId, taskEl) {

    let response = await fetch('api/tdl_undo_task.php?id='+ taskId);
    let undoRes = await response.json();


    if (undoRes.success == "yes") {
        // get the checkbox input of this task element
        //let checkboxEl = taskEl.querySelector('input[type="checkbox"]');

        //checkboxEl.checked = false;
        
        taskEl.removeAttribute('completed');
    }

    console.log(taskEl);
    console.log(undoRes);

}



async function toggleTask(checkboxWrapperEl) {

    taskEl = checkboxWrapperEl.parentElement;

    // do nothing if the task element has already been completed (or has 'completed' attribute)
    if (!taskEl.classList.contains('todo-data')) { return }

    // get the task id 
    let taskId = taskEl.dataset.taskId;

    if (taskEl.hasAttribute('completed')) {
        undoTaskById(taskId, taskEl);
    }else {
        completeTaskById(taskId, taskEl);
    }

}


function handleCheckboxClick(event) {
    console.log(event);
}

function getTaskHTML(task) {
    return `
        <li class="todo-data" data-task-id="${task.id}" ${task.completed == 1 ? 'completed' : ''}>
            <button class="checkbox-wrapper" onclick="toggleTask(this)">
                <span class="material-icons checkbox" blank>check_box_outline_blank</span>
                <span class="material-icons checkbox" checked>check_box</span>
            </button>
            <p>${task.description}</p>
            <button class="todo-delete-btn" onclick="deleteTaskById(${task.id})"><span class="material-icons icon">close</span></button>
        </li>
    `;
}

async function addTaskWithTodolistId(todolistId) {
    // get the todolist element with 'todolistId'
    let taskDescEl = document.querySelector(`.task-description[data-todolist-id='${todolistId}']`);

    let taskValue = taskDescEl.value;

    let response = await fetch(`api/tdl_add_task.php?todo_list_id=${todolistId}&description=${taskValue}`);

    let taskRes = await response.json();

    if (taskRes.success == "yes"){
        let taskData = taskRes.data; 

        let todolistContentEl = document.querySelector(`.todo-list[data-id='${todolistId}'] .content`);

        todolistContentEl.insertAdjacentHTML('beforeend', getTaskHTML(taskData));
        todolistContentEl.scrollTop = todolistContentEl.scrollHeight;

        taskDescEl.value = '';
    }

    // get description from todolistEl
};

// async function completeTaskById(taskId){
//     console.log('Task is compleded', taskId);
    
//     let response = await fetch ('api/tdl_complete_task.php?=id'+ taskId);
//     let completeRes = await response.json();
// }

function handleDescKeyup(event) {
    if (!event) { return }

    // console.log(event.target);
    let todolistId = event.target.dataset.todolistId;

    if (event.key === "Enter" || event.keyCode === 13) {
        addTaskWithTodolistId(todolistId);
    }

    console.log("Key code is " + event.keyCode);
}

function getTodolistHTML(data, tasks = []) {

    let content = "";

    tasks.forEach(function(task) {
        content += getTaskHTML(task);
    });

    return `
        <li class="todo-list" data-id="${data.id}">
            <div class="bar">
                <button onclick="deleteTodolistById(${data.id})"><span class="material-icons">delete_outline</span></button>
                
                <div class="info">
                    <h2 class="todo-name">${data.title}</h2>
                    <h4 class="todo-date">${data.created_at}</h4>
                </div>
            </div>
            
            <ul class="content">${content}</ul>
            
            <div class="input-container">
                <input data-todolist-id="${data.id}" class="task-description" type="text" placeholder="What do you want to do?" onKeyUp="handleDescKeyup()">
                <button onclick="addTaskWithTodolistId(${data.id})">Add</button>
            </div>
        </li>`;
}




async function getAllTodoLists() {

    let response = await fetch('api/tdl_fetch_all.php');
    let result = await response.json();

    let todoListContainerEl = document.querySelector('.todo-list-container');

    if (result.success == "yes") {

        console.log(result);

        result.data.forEach(function(todolist){

            todoListContainerEl.insertAdjacentHTML('beforeend', getTodolistHTML(todolist, todolist.tasks));

            // select the task description element
            let taskDescEl = document.querySelector(`.task-description[data-todolist-id='${todolist.id}']`);
            taskDescEl.addEventListener('keyup', handleDescKeyup);

        });

    }

    
    return result;
};

async function createTodolist(){
  

    let newListEl = document.getElementById("newList");
    let title = newListEl.value;
    let response = await fetch('api/tdl_create_todolist.php?title=' + title);
    let todolistRes = await response.json();

    if(todolistRes.success == "yes"){
        let todolistData = todolistRes.data;

        let creatorEl = document.getElementById("creator");

        creatorEl.insertAdjacentHTML('afterend', getTodolistHTML(todolistData));

        newListEl.value = "";

        

        console.log(todolistData);
    }


   
}

window.onload = async () => {

    let todo_lists = await getAllTodoLists();

    console.log(todo_lists);
};