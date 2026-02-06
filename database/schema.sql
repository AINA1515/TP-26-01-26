drop database if exists siteTemplate;
create database siteTemplate;
use siteTemplate;

create table users (
    id int auto_increment primary key,
    username varchar(50) not null unique,
    mdp varchar(255),
    email varchar(100)  unique,
    photoProfil varchar(255) ,
    created_at timestamp default current_timestamp
);

create table messages (
    id int auto_increment primary key,
    from_user_id int not null,
    to_user_id int not null,
    message_text text not null,
    is_read boolean default false,
    created_at timestamp default current_timestamp,
    foreign key (from_user_id) references users(id),
    foreign key (to_user_id) references users(id)
);