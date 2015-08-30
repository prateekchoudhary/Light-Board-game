-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 18, 2010 at 02:06 AM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.4

CREATE DATABASE lb_engine;

USE lb_engine;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `bitrhymes_engine`
--

-- --------------------------------------------------------

--
-- Table structure for table `engine_users`
--

CREATE TABLE IF NOT EXISTS `engine_users` (
  `userid` varchar(10) NOT NULL,
  `session` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL,
  `sequence` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userid`),
  KEY `sequence` (`sequence`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

