<template>
    <div>
        <button class="btn btn-secondary" @click.prevent="readTasks()">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-clockwise" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
            </svg>
        </button>

        <FlashMessage></FlashMessage>

        <div class="newCard card w-75">
            New Task:
            <form id="newTask">
                <div class="form-group">
                    <input type="text" class="form-control" id="title" aria-describedby="taskTitle" placeholder="Title" v-model="newTask.title">
                    <small id="titleHelp" class="form-text text-muted">Some unique task you have</small>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_done" v-model="newTask.is_done">
                    <label class="form-check-label" for="is_done">Completed</label>
                    <small id="completedHelp" class="form-text text-muted">Is this task done?</small>
                </div>
                <div class="form-group">
                    <datepicker v-model="newTask.due_date" name="due_date"></datepicker>
                    <small id="dueHelp" class="form-text text-muted">When is this task due?</small>
                </div>
                <button type="submit" class="btn btn-primary float-right" @click.prevent="createTask();">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                </button>
            </form>
        </div>

        <div v-for="task in tasks" v-bind:key="task.id">
            <task :title="task.title"
                :id="task.id"
                :due_date="task.due_date"
                :is_done="task.is_done"
                @complete="handleCompleteTask"
                @delete="handleDeleteTask"
                @update="handleUpdateTask">
            </task>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tasks: [],
                newTask: this.cleanTask(),
            };
        },
        mounted() {
            this.readTasks();
        },
        methods: {
            cleanTask() {
                return {
                    is_done: false,
                };
            },
            async flashError(value) {
                this.deleteTask(value);
            },
            async handleDeleteTask(value) {
                this.deleteTask(value);
            },
            async handleCompleteTask(value) {
                this.updateTask(value, { is_done: true });
            },
            async handleUpdateTask(value) {
                this.flashMessage.error({title: 'Updating Tasks Not Ready Yet'});
                //this.updateTask(value, newTask);
            },
            async readTasks() {
                try {
                    const { data } = await axios.get(window.taskApiUrl);
                    this.tasks = data;
                } catch (e) {
                    const message = e.response.data.errors || e.message;
                    this.flashMessage.error({title: 'Error Loading Tasks', message});
                }
            },
            async createTask() {
                try {
                    const { data } = await axios.post(window.taskApiUrl, this.newTask);
                    this.newTask = this.cleanTask();
                    this.tasks.push(data);
                } catch (e) {
                    const message = e.response.data.errors || e.message;
                    this.flashMessage.error({title: 'Error Creating Tasks', message});
                }
            },
            async updateTask(id, newTask) {
                try {
                    const { data } = await axios.put(`${window.taskApiUrl}/${id}`, newTask);
                    let index = this.tasks.findIndex(task => task.id === id);
                    Object.assign(this.tasks[index], data);
                } catch (e) {
                    const message = e.response.data.errors || e.message;
                    this.flashMessage.error({title: 'Error Updating Task', message});
                }
            },
            async deleteTask(id) {
                try {
                    const { data } = await axios.delete(`${window.taskApiUrl}/${id}`);
                    let index = this.tasks.findIndex(task => task.id === id);
                    this.tasks.splice(index, 1);
                } catch (e) {
                    const message = e.response.data.errors || e.message;
                    this.flashMessage.error({title: 'Error Deleting Task', message});
                }
            },
        }
    }
</script>
