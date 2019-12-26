-- Adminer 4.7.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

INSERT INTO `data_reuters` (`id`, `Rank`, `Title`, `TotalCites`, `JournalImpactFactor`, `EigenfactorScore`, `ISSN`, `EISSN`, `Categoryname`) VALUES
(12301,	1,	'CA-A CANCER JOURNAL FOR CLINICIANS',	'32,410',	'223.679',	'0.077370',	'0007-9235',	'',	''),
(12302,	2,	'Nature Reviews Materials',	'7,901',	'74.449',	'0.033870',	'2058-8437',	'',	''),
(12303,	3,	'NEW ENGLAND JOURNAL OF MEDICINE',	'344,581',	'70.670',	'0.686700',	'0028-4793',	'',	''),
(12304,	4,	'LANCET',	'247,292',	'59.102',	'0.427870',	'0140-6736',	'',	''),
(12305,	5,	'NATURE REVIEWS DRUG DISCOVERY',	'32,266',	'57.618',	'0.054890',	'1474-1776',	'',	''),
(12306,	6,	'CHEMICAL REVIEWS',	'188,635',	'54.301',	'0.267170',	'0009-2665',	'',	''),
(12307,	7,	'Nature Energy',	'11,113',	'54.000',	'0.040630',	'2058-7546',	'',	''),
(12308,	8,	'NATURE REVIEWS CANCER',	'50,529',	'51.848',	'0.074080',	'1474-175X',	'',	''),
(12309,	9,	'JAMA-JOURNAL OF THE AMERICAN MEDICAL ASSOCIATION',	'156,350',	'51.273',	'0.300810',	'0098-7484',	'',	''),
(12310,	10,	'NATURE REVIEWS IMMUNOLOGY',	'41,499',	'44.019',	'0.080220',	'1474-1733',	'',	'');

INSERT INTO `data_scopus` (`Title`, `CiteScore`, `CitationCount`, `SJR`, `RANK`, `Publisher`, `Type`, `OpenAccess`, `ScopusSubSubjectArea`, `Quartile`, `ScopusSourceID`, `PrintISSN`, `EISSN`, `id`) VALUES
('Ca-A Cancer Journal for Clinicians',	'130,47',	'16961',	'61,786',	'1',	'Wiley-Blackwell',	'Journal',	'NO',	'Hematology',	'Quartile 1',	'https://www.scopus.com/sourceid/28773',	'00079235',	'15424863',	1),
('Ca-A Cancer Journal for Clinicians',	'130,47',	'16961',	'61,786',	'1',	'Wiley-Blackwell',	'Journal',	'NO',	'Oncology',	'Quartile 1',	'https://www.scopus.com/sourceid/28773',	'00079235',	'15424863',	2),
('MMWR. Recommendations and reports : Morbidity and mortality weekly report. Recommendations and reports / Centers for Disease Control',	'63,12',	'1010',	'34,638',	'1',	'Centers for Disease Control and Prevention (CDC)',	'Journal',	'YES',	'Epidemiology',	'Quartile 1',	'https://www.scopus.com/sourceid/19434',	'10575987',	'15458601',	3),
('MMWR. Recommendations and reports : Morbidity and mortality weekly report. Recommendations and reports / Centers for Disease Control',	'63,12',	'1010',	'34,638',	'1',	'Centers for Disease Control and Prevention (CDC)',	'Journal',	'YES',	'Health(social science)',	'Quartile 1',	'https://www.scopus.com/sourceid/19434',	'10575987',	'15458601',	4),
('MMWR. Recommendations and reports : Morbidity and mortality weekly report. Recommendations and reports / Centers for Disease Control',	'63,12',	'1010',	'34,638',	'1',	'Centers for Disease Control and Prevention (CDC)',	'Journal',	'YES',	'Health, Toxicology and Mutagenesis',	'Quartile 1',	'https://www.scopus.com/sourceid/19434',	'10575987',	'15458601',	5),
('MMWR. Recommendations and reports : Morbidity and mortality weekly report. Recommendations and reports / Centers for Disease Control',	'63,12',	'1010',	'34,638',	'1',	'Centers for Disease Control and Prevention (CDC)',	'Journal',	'YES',	'Health Information Management',	'Quartile 1',	'https://www.scopus.com/sourceid/19434',	'10575987',	'15458601',	6),
('Chemical Reviews',	'51,08',	'44389',	'23,414',	'1',	'American Chemical Society',	'Journal',	'NO',	'General Chemistry',	'Quartile 1',	'https://www.scopus.com/sourceid/23340',	'00092665',	'15206890',	7),
('Chemical Society Reviews',	'39,42',	'42223',	'17,633',	'2',	'RSC',	'Journal',	'NO',	'General Chemistry',	'Quartile 1',	'https://www.scopus.com/sourceid/23350',	'03060012',	'14604744',	8),
('Reviews of Modern Physics',	'34,49',	'4242',	'17,567',	'1',	'American Physical Society',	'Journal',	'NO',	'General Physics and Astronomy',	'Quartile 1',	'https://www.scopus.com/sourceid/29719',	'00346861',	'15390756',	9),
('Materials Science and Engineering: R: Reports',	'31,32',	'1190',	'8,408',	'1',	'Elsevier',	'Journal',	'NO',	'General Materials Science',	'Quartile 1',	'https://www.scopus.com/sourceid/17814',	'0927796X',	' ',	10);

INSERT INTO `data_thomson_meta` (`id`, `Fulltitle`, `ISSN`, `EISSN`, `Categoryname`, `Rank`, `TotalCites`, `JournalImpactFactor`, `EigenfactorScore`) VALUES
(1,	'2D Materials',	'2053-1583',	'2053-1583',	'MATERIALS SCIENCE',	'441',	'3,284',	'7,042',	'0,01174'),
(2,	'3 Biotech',	'2190-572X',	'2190-5738',	'BIOLOGY & BIOCHEMISTRY',	'6571',	'1,108',	'1,497',	'0,00221'),
(3,	'3D Printing and Additive Manufacturing',	'2329-7662',	'2329-7670',	'ENGINEERING',	'4018',	'260',	'2,304',	'0,00074'),
(4,	'4OR-A Quarterly Journal of Operations Research',	'1619-4500',	'1614-2411',	'ENGINEERING',	'7771',	'460',	'1,206',	'0,00064'),
(5,	'AAPG BULLETIN',	'0149-1423',	'1558-9153',	'GEOSCIENCES',	'2252',	'13,032',	'3,208',	'0,00939'),
(6,	'AAPS Journal',	'1550-7416',	'1550-7416',	'PHARMACOLOGY & TOXICOLOGY',	'1576',	'5,333',	'3,804',	'0,0091'),
(7,	'AAPS PHARMSCITECH',	'1530-9932',	'1530-9932',	'PHARMACOLOGY & TOXICOLOGY',	'3167',	'5,965',	'2,666',	'0,00506'),
(8,	'AATCC Journal of Research',	'2330-5517',	'2330-5517',	'MATERIALS SCIENCE',	'11616',	'39',	'0,34',	'0,00009'),
(9,	'AATCC REVIEW',	'1532-8813',	'1532-8813',	'MATERIALS SCIENCE',	'11637',	'205',	'0,333',	'0,00004'),
(10,	'Abacus-A Journal of Accounting Finance and Business Studies',	'0001-3072',	'1467-6281',	'ECONOMICS & BUSINESS',	'10515',	'627',	'0,609',	'0,00027');

INSERT INTO `data_t_scopus` (`id`, `ScopusSourceID`, `Title`, `CiteScore`, `CitationCount`, `SJR`, `RANK`, `Publisher`, `OpenAccess`, `ScopusSubSubjectArea`, `Quartile`, `PrintISSN`, `EISSN`) VALUES
(58827,	'https://www.scopus.com/sourceid/28773',	'Ca-A Cancer Journal for Clinicians',	'160,19',	'20184',	'72,576',	'1',	'Wiley-Blackwell',	'NO',	'Hematology',	'Quartile 1',	'00079235',	'15424863'),
(58828,	'https://www.scopus.com/sourceid/19434',	'MMWR. Recommendations and reports : Morbidity and mortality weekly report. Recommendations and reports / Centers for Disease Control',	'87,75',	'1053',	'48,894',	'1',	'Centers for Disease Control and Prevention (CDC)',	'YES',	'Epidemiology',	'Quartile 1',	'10575987',	'15458601'),
(58829,	'https://www.scopus.com/sourceid/23340',	'Chemical Reviews',	'54,26',	'46227',	'22,157',	'1',	'American Chemical Society',	'NO',	'General Chemistry',	'Quartile 1',	'00092665',	'15206890'),
(58830,	'https://www.scopus.com/sourceid/23350',	'Chemical Society Reviews',	'41,35',	'40522',	'16,116',	'2',	'Royal Society of Chemistry',	'NO',	'General Chemistry',	'Quartile 1',	'03060012',	'14604744'),
(58831,	'https://www.scopus.com/sourceid/29719',	'Reviews of Modern Physics',	'39,2',	'4979',	'17,337',	'1',	'American Physical Society',	'NO',	'General Physics and Astronomy',	'Quartile 1',	'00346861',	'15390756'),
(58832,	'https://www.scopus.com/sourceid/58530',	'National vital statistics reports : from the Centers for Disease Control and Prevention, National Center for Health Statistics, National Vital Statistics System',	'38,91',	'1245',	'27,31',	'1',	'Public Health Services, US Dept of Health and Human Services',	'NO',	'Life-span and Life-course Studies',	'Quartile 1',	'15518922',	'15518930'),
(58833,	'https://www.scopus.com/sourceid/21100812243',	'Nature Reviews Materials',	'37,75',	'7362',	'34,171',	'1',	'Nature Publishing Group',	'NO',	'Electronic, Optical and Magnetic Materials',	'Quartile 1',	'',	'20588437'),
(58834,	'https://www.scopus.com/sourceid/17900156715',	'IEEE Communications Surveys and Tutorials',	'33,62',	'11129',	'5,123',	'1',	'Institute of Electrical and Electronics Engineers Inc.',	'NO',	'Electrical and Electronic Engineering',	'Quartile 1',	'1553877X',	''),
(58835,	'https://www.scopus.com/sourceid/17500155114',	'Energy and Environmental Science',	'32,34',	'29396',	'13,103',	'1',	'Royal Society of Chemistry',	'NO',	'Environmental Chemistry',	'Quartile 1',	'17545692',	''),
(58836,	'https://www.scopus.com/sourceid/27538',	'Progress in Energy and Combustion Science',	'29,72',	'1932',	'7,508',	'1',	'Elsevier BV',	'NO',	'General Chemical Engineering',	'Quartile 1',	'03601285',	''),
(58837,	'https://www.scopus.com/sourceid/17899',	'Progress in Materials Science',	'28,12',	'3346',	'7,649',	'1',	'Elsevier Ltd',	'NO',	'General Materials Science',	'Quartile 1',	'00796425',	'');
