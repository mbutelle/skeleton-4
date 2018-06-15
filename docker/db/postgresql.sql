DO
$body$
BEGIN
   IF NOT EXISTS (
      SELECT *
      FROM   pg_catalog.pg_user
      WHERE  usename = 'appbuilder'
   )
   THEN
      CREATE ROLE appbuilder SUPERUSER LOGIN;
   END IF;
END
$body$;
