(function() {
    "use strict";

    var app = angular.module('myApp', ['ng-admin']);

    app.directive('customPostLink', ['$location', function($location) {
        return {
            restrict: 'E',
            template: '<a ng-click="displayPost(entity)">View&nbsp;post</a>',
            controller: function($scope, $location) {},
            link: function($scope, element, attributes) {
                $scope.displayPost = function(entity) {
                    var postId = entity.getField('post_id').value;
                    $location.path('/edit/post/' + postId);
                }
            }
        }
    }]);

    function truncate(value) {
        if (!value) {
            return '';
        }

        return value.length > 50 ? value.substr(0, 50) + '...' : value;
    }

    app.config(function(RestangularProvider) {
        // use the custom query parameters function to format the API request correctly
        RestangularProvider.addFullRequestInterceptor(function(element, operation, what, url, headers, params) {
            if (operation == "getList") {
                // custom pagination params
                params._offset = (params._page - 1) * params._perPage;
                params._limit = params._perPage;
                delete params._page;
                delete params._perPage;

                // custom filter params
                if (params._filters) {
                    for (var filter in params._filters) {
                        params[filter] = params._filters[filter];
                    }
                    delete params._filters;
                }
            }
            return { params: params };
        });
    });

    app.config(function($provide, NgAdminConfigurationProvider) {
        $provide.factory("PostAdmin", function() {
            var nga = NgAdminConfigurationProvider;
            var post = nga.entity('post');

            post.dashboardView()
                .fields([
                    nga.field('id', 'number'),
                    nga.field('title', 'string'),
                    nga.field('body', 'text').map(truncate),
                    nga.field('tags', 'reference_many')
                        .targetEntity(nga.entity('tag'))
                        .targetField(nga.field('name')),
                ]);

            post.listView()
                .infinitePagination(false)
                .fields([
                    nga.field('id', 'number'),
                    nga.field('title', 'string'),
                    nga.field('body', 'text').map(truncate),
                    nga.field('tags', 'reference_many')
                        .targetEntity(nga.entity('tag'))
                        .targetField(nga.field('name'))
                ])
                .listActions(['show', 'edit', 'delete']);

            post.creationView()
                .fields([
                    nga.field('title', 'string'),
                    nga.field('body', 'text'),
                    nga.field('tags', 'reference_many')
                        .targetEntity(nga.entity('tag'))
                        .targetField(nga.field('name'))
                ]);

            post.editionView()
                .fields([
                    nga.field('id', 'number'),
                    nga.field('title', 'string'),
                    nga.field('body', 'text'),
                    nga.field('tags', 'reference_many')
                        .targetEntity(nga.entity('tag'))
                        .targetField(nga.field('name')),
                    nga.field('comments', 'referenced_list')
                        .targetEntity(nga.entity('comment'))
                        .targetReferenceField('post_id')
                        .targetFields([
                            nga.field('id', 'number'),
                            nga.field('body', 'text'),
                    ])
                ]);

            post.showView()
                .fields([
                    nga.field('id', 'number'),
                    nga.field('title', 'string'),
                    nga.field('body', 'text'),
                    nga.field('tags', 'reference_many')
                        .targetEntity(nga.entity('tag'))
                        .targetField(nga.field('name')),
                    nga.field('comments', 'referenced_list')
                        .targetEntity(nga.entity('comment'))
                        .targetReferenceField('post_id')
                        .targetFields([
                            nga.field('id', 'number'),
                            nga.field('body', 'text'),
                    ])
                ]);

            return post;
        });
    });

    app.config(function($provide, NgAdminConfigurationProvider) {
        $provide.factory("CommentAdmin", function() {
            var nga = NgAdminConfigurationProvider;
            var comment = nga.entity('comment');

            comment.dashboardView()
                .fields([
                    nga.field('id', 'number'),
                    nga.field('body', 'text'),
                    nga.field('created_at', 'date'),
                    nga.field('post_id', 'reference')
                        .targetEntity(nga.entity('post'))
                        .targetField(nga.field('title'))
                ]);

            comment.listView()
                .infinitePagination(true)
                .fields([
                    nga.field('id', 'number'),
                    nga.field('body', 'text'),
                    nga.field('created_at', 'date'),
                    nga.field('post_id', 'reference')
                        .targetEntity(nga.entity('post'))
                        .targetField(nga.field('title')),
                ])
                .listActions(['show', 'edit', 'delete'])
                .filters([
                    nga.field('today', 'boolean').map(function() {
                        var now = new Date(),
                            year = now.getFullYear(),
                            month = now.getMonth() + 1,
                            day = now.getDate();
                        month = month < 10 ? '0' + month : month;
                        day = day < 10 ? '0' + day : day;
                        return {
                            created_at: [year, month, day].join('-')
                        };
                    })
                ]);

            comment.creationView()
                .fields([
                    nga.field('body', 'text'),
                    nga.field('created_at', 'date'),
                    nga.field('post_id', 'reference')
                        .targetEntity(nga.entity('post'))
                        .targetField(nga.field('title')),
                ]);

            comment.editionView()
                .fields([
                    nga.field('id', 'number'),
                    nga.field('body', 'text'),
                    nga.field('created_at', 'date'),
                    nga.field('post_id', 'reference')
                        .targetEntity(nga.entity('post'))
                        .targetField(nga.field('title')),
                ]);

            comment.showView()
                .fields([
                    nga.field('id', 'number'),
                    nga.field('body', 'text'),
                    nga.field('created_at', 'date'),
                    nga.field('post_id', 'reference')
                        .targetEntity(nga.entity('post'))
                        .targetField(nga.field('title')),
                ]);

            return comment;
        });
    });

    app.config(function($provide, NgAdminConfigurationProvider) {
        $provide.factory("TagAdmin", function() {
            var nga = NgAdminConfigurationProvider;
            var tag = nga.entity('tag');

            tag.dashboardView()
                .infinitePagination(false)
                .fields([
                    nga.field('id', 'number'),
                    nga.field('name', 'string'),
                ]);

            tag.listView()
                .fields([
                    nga.field('id', 'number'),
                    nga.field('name', 'string'),
                ])
                .listActions(['show', 'edit', 'delete']);

            tag.creationView()
                .fields([
                    nga.field('name', 'string')
                        .validation({ required: true, maxLength: 150 })
                ]);

            tag.editionView()
                .fields([
                    nga.field('id', 'number').editable(false),
                    tag.creationView().fields(),
                ]);

            tag.showView()
                .fields([
                    nga.field('id', 'number'),
                    nga.field('name', 'string'),
                ]);

            return tag;
        });
    });

    app.config(function(NgAdminConfigurationProvider, PostAdminProvider, CommentAdminProvider, TagAdminProvider) {
        var admin = NgAdminConfigurationProvider
            .application('')
            .baseApiUrl(location.protocol + '//' + location.hostname + (location.port ? ':' + location.port : '') + '/api/')

        admin
            .addEntity(PostAdminProvider.$get())
            .addEntity(CommentAdminProvider.$get())
            .addEntity(TagAdminProvider.$get())
        ;

        NgAdminConfigurationProvider.configure(admin);
    });
})();

