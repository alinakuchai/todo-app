var $todoModule = angular.module('todoModule', ['ui.sortable']);

$todoModule.controller('ToDoController', function ($scope, $http, $timeout) {
    var url = "ajax.php";

    $scope.newProject = {
        name: ""
    };
    $scope.addList = function () {
        $scope.toggleForm = true;
        setTimeout(function () {
            var input = angular.element("#newName");
            input.focus().val(input.val());
            jQuery(document).on('click.closeForm', function (e) {
                var target = e.toElement || e.target;
                if (!(target.id === "newName")) {
                    $scope.toggleForm = false;
                    jQuery(document).off('click.closeForm');
                    if (target.className == "add-project") {
                        $scope.saveProject($scope.newProject.name);
                    } else {
                        $scope.newProject.name = '';
                    }
                    $scope.$apply();
                };
            });
        }, 0);
    };

    /* Edit existing project*/
    $scope.editName = function (obj) {
        obj.editing = true;
        setTimeout(function () {
            $scope.editInput = obj.status ? angular.element("#task" + obj.id) : angular.element("#proj" + obj.id);
            $scope.editInput.focus().val($scope.editInput.val());
            jQuery(document).on('click.stopEditName', function (e) {
                var target = e.toElement || e.target;
                if (!(target.className === 'editingInput')) {
                    obj.editing = false;
                    jQuery(document).off('click.stopEditName');
                    if (target.className.indexOf("change-name") !== -1 && $scope.editInput.val()) {
                        $scope.changeName(obj);
                    } else {
                        $scope.editInput.val(obj.name);
                    }
                    $scope.$apply();
                };
            });
        }, 0);
    };

    $scope.changeName = function (obj) {
        obj.name = $scope.editInput.val();
        if (obj.status) {
            $scope.saveTask(obj.name, "", obj.id);
        } else {
            $scope.saveProject(obj.name, obj.id);
        }
    };

    /* Save new or update project */

    $scope.saveProject = function (name, id) {
        if (!name) {
            return;
        }
        $http({
            method: 'post',
            url: url,
            data: $.param({
                'project': name,
                'id': id,
                'type': 'save_project'
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).
        success(function (data, status, headers, config) {
            var check = $scope.projects.filter(function (obj) {
                return obj.id == data.id;
            });
            if (check.length === 0) {
                $scope.projects.push({
                    id: data.id,
                    name: name
                });
            }
            $scope.newProject.name = "";
        }).error(function (data, status, headers, config) {
            //$scope.codeStatus = response || "Request failed";
            console.error(data);
        });
    };

    $scope.saveTask = function (taskName, project, id) {
        if (!taskName) {
            return;
        }
        $http({
            method: 'post',
            url: url,
            data: $.param({
                'task': taskName,
                'project_id': project.id,
                'id': id,
                'type': 'save_task'
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).
        success(function (data, status, headers, config) {
            if (!project.tasks) {
                project.tasks = [];
            }
            if (project) {
                project.tasks.push({
                    id: data.id,
                    name: taskName,
                    status: "0"
                });
                project.newTask.name = "";
            }
        }).error(function (data, status, headers, config) {
            //$scope.codeStatus = response || "Request failed";
            console.log(data);
        });
    };

    $scope.changeTaskStatus = function (task) {
        $http({
            method: 'post',
            url: url,
            data: $.param({
                'id': task.id,
                'status': task.status,
                'type': 'change_status_task'
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).
        success(function (data, status, headers, config) {
            console.log(task);
        }).error(function (data, status, headers, config) {
            //$scope.codeStatus = response || "Request failed";
            console.log(data);
        });
    };
    /* Delete project */

    $scope.deleteProject = function (project) {
        console.log(project, project.id);
        var r = confirm("Are you sure want to delete this project!");
        if (r) {
            $http({
                method: 'post',
                url: url,
                data: $.param({
                    'id': project.id,
                    'type': 'delete_project'
                }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).
            success(function (data, status, headers, config) {
                if (data.success) {
                    var index = $scope.projects.indexOf(project);
                    $scope.projects.splice(index, 1);
                } else {
                    $scope.messageFailure(data.message);
                }
            }).
            error(function (data, status, headers, config) {
                //$scope.messageFailure(data.message);
            });
        }
    };

    $scope.deleteTask = function (task, project) {
        console.log(task, task.id);
        var r = confirm("Are you sure want to delete this task!");
        if (r) {
            $http({
                method: 'post',
                url: url,
                data: $.param({
                    'id': task.id,
                    'type': 'delete_task'
                }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).
            success(function (data, status, headers, config) {
                if (data.success) {
                    var index = project.tasks.indexOf(task);
                    project.tasks.splice(index, 1);
                } else {
                    $scope.messageFailure(data.message);
                }
            }).
            error(function (data, status, headers, config) {
                //$scope.messageFailure(data.message);
            });
        }
    };
    /* Get projects */

    $scope.getProject = function () {
        $http({
            method: 'post',
            url: url,
            data: $.param({
                'type': 'getProjects'
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).
        success(function (data, status, headers, config) {
            $scope.projects = data.data || [];
        }).
        error(function (data, status, headers, config) {
            console.error(data);
        });
    };
    
    $scope.sortTasks = function (project) {
        var arrayId = [];
        project.tasks.forEach(function (task) {
            arrayId.push(task.id);
        });
        var stringId = arrayId.reverse().join();
        $http({
            method: 'post',
            url: url,
            data: $.param({
                'type': 'sortTasks',
                'stringId': stringId
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).
        success(function (data, status, headers, config) {
            console.log(data);
        }).
        error(function (data, status, headers, config) {
            //$scope.codeStatus = response || "Request failed";
            console.log(data);
        });
    };
    $scope.sortableOptions = {
        handle: '.myHandle',
        stop: function (e, ui) {
            $scope.sortTasks(ui.item.scope().project);
        }
    };
    
    $scope.getProject();
    angular.element(document).on('click', 'a[href="#"]', function (e) {
        e.preventDefault();
    });
});